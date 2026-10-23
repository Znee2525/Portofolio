import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
document.documentElement.classList.add("has-js");

const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
const media = gsap.matchMedia();
const cardReveals = new Map();
const cleanups = [];
const initialHash = window.location.hash;

function readPreference(key) {
    try {
        return localStorage.getItem(key);
    } catch {
        return null;
    }
}

function savePreference(key, value) {
    try {
        localStorage.setItem(key, value);
    } catch {
        // The controls also work when browser storage is unavailable.
    }
}

// Navigation remains ordinary anchor navigation, including without JavaScript.
const navigation = document.querySelector("#main-navigation");
const menuToggle = document.querySelector(".menu-toggle");

function setMenu(open, returnFocus = false) {
    navigation?.classList.toggle("is-open", open);
    menuToggle?.setAttribute("aria-expanded", String(open));
    menuToggle?.setAttribute(
        "aria-label",
        open ? "Tutup navigasi" : "Buka navigasi",
    );
    if (returnFocus) menuToggle?.focus();
}

menuToggle?.addEventListener("click", () => {
    setMenu(menuToggle.getAttribute("aria-expanded") !== "true");
});
navigation?.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => setMenu(false));
});
document.addEventListener("keydown", (event) => {
    if (
        event.key === "Escape" &&
        menuToggle?.getAttribute("aria-expanded") === "true"
    ) {
        setMenu(false, true);
    }
});
document.addEventListener("click", (event) => {
    if (!event.target.closest(".site-header")) setMenu(false);
});
const desktopQuery = matchMedia("(min-width: 768px)");
desktopQuery.addEventListener("change", () => setMenu(false));

const navObserver = new IntersectionObserver(
    (entries) => {
        const entered = entries.filter((entry) => entry.isIntersecting);
        if (!entered.length) return;
        const section = entered[0].target.id;
        navigation?.querySelectorAll("[data-nav-section]").forEach((link) => {
            if (link.dataset.navSection === section)
                link.setAttribute("aria-current", "location");
            else link.removeAttribute("aria-current");
        });
    },
    { rootMargin: "-15% 0px -55% 0px", threshold: 0 },
);
document
    .querySelectorAll("main > section[id]")
    .forEach((section) => navObserver.observe(section));
cleanups.push(() => navObserver.disconnect());

// Ambient particles are finite and can be disabled independently of navigation.
const ambientToggle = document.querySelector(".ambient-toggle");
function setAmbient(enabled) {
    const active = enabled && !reducedMotion.matches;
    document.body.classList.toggle("ambient-paused", !active);
    ambientToggle?.setAttribute("aria-pressed", String(active));
    ambientToggle?.setAttribute(
        "aria-label",
        active ? "Matikan partikel dan rune" : "Aktifkan partikel dan rune",
    );
}
setAmbient(readPreference("zidane-ambient") !== "off");
ambientToggle?.addEventListener("click", () => {
    const enabled = ambientToggle.getAttribute("aria-pressed") !== "true";
    savePreference("zidane-ambient", enabled ? "on" : "off");
    setAmbient(enabled);
});
reducedMotion.addEventListener("change", () =>
    setAmbient(readPreference("zidane-ambient") !== "off"),
);

// Native dialogs provide focus containment, Escape, and an ordinary page fallback.
let dialogTrigger = null;
let closingDialog = false;
function openDialog(dialog, trigger) {
    if (!dialog || typeof dialog.showModal !== "function") return false;
    if (dialog.open) return true;
    dialogTrigger = trigger;
    closingDialog = false;
    gsap.killTweensOf(dialog);
    dialog.showModal();
    dialog.scrollTop = 0;
    if (!reducedMotion.matches) {
        gsap.fromTo(
            dialog,
            {
                opacity: 0,
                y: 20,
                rotateY: -4,
                transformPerspective: 1200,
                transformOrigin: "left center",
            },
            {
                opacity: 1,
                y: 0,
                rotateY: 0,
                duration: 0.45,
                ease: "power3.out",
                clearProps: "transform,opacity,transformOrigin",
            },
        );
    }
    return true;
}
function closeDialog(dialog) {
    if (!dialog.open || closingDialog) return;
    closingDialog = true;
    const finish = () => {
        dialog.close();
        gsap.set(dialog, { clearProps: "transform,opacity,transformOrigin" });
        closingDialog = false;
    };
    gsap.killTweensOf(dialog);
    if (reducedMotion.matches) finish();
    else
        gsap.to(dialog, {
            opacity: 0,
            y: 10,
            duration: 0.17,
            onComplete: finish,
        });
}
document.querySelectorAll("a[data-quest], a[data-record]").forEach((link) => {
    link.addEventListener("click", (event) => {
        if (
            event.metaKey ||
            event.ctrlKey ||
            event.shiftKey ||
            event.altKey ||
            event.button !== 0
        )
            return;
        const id = link.hasAttribute("data-record")
            ? "character-record"
            : `quest-${link.dataset.quest}`;
        if (openDialog(document.getElementById(id), link))
            event.preventDefault();
    });
});
document.querySelectorAll("dialog").forEach((dialog) => {
    dialog
        .querySelector("[data-close-dialog]")
        ?.addEventListener("click", () => closeDialog(dialog));
    dialog.addEventListener("cancel", (event) => {
        event.preventDefault();
        closeDialog(dialog);
    });
    dialog.addEventListener("click", (event) => {
        if (event.target !== dialog) return;
        const rect = dialog.getBoundingClientRect();
        if (
            event.clientX < rect.left ||
            event.clientX > rect.right ||
            event.clientY < rect.top ||
            event.clientY > rect.bottom
        )
            closeDialog(dialog);
    });
    dialog.addEventListener("close", () => {
        if (dialogTrigger?.isConnected)
            dialogTrigger.focus({ preventScroll: true });
        dialogTrigger = null;
    });
});

// Filters expose the result count and preserve real links on every card.
const filters = [...document.querySelectorAll("[data-filter]")];
const cards = [...document.querySelectorAll(".quest-card")];
filters.forEach((filter) => {
    filter.addEventListener("click", () => {
        const category = filter.dataset.filter;
        filters.forEach((item) =>
            item.setAttribute("aria-pressed", String(item === filter)),
        );
        cards.forEach((card) => {
            const reveal = cardReveals.get(card);
            reveal?.scrollTrigger?.kill();
            reveal?.kill();
            gsap.killTweensOf(card);
            gsap.set(card, { clearProps: "transform,opacity,visibility" });
            card.hidden =
                category !== "all" && card.dataset.category !== category;
        });
        const visibleCards = cards.filter((card) => !card.hidden);
        const count = visibleCards.length;
        document.querySelector("#quest-count").textContent =
            `${count} ${count === 1 ? "quest" : "quests"} in the archive`;
        if (!reducedMotion.matches)
            gsap.fromTo(
                visibleCards,
                { opacity: 0, y: 12 },
                {
                    opacity: 1,
                    y: 0,
                    stagger: 0.06,
                    duration: 0.35,
                    clearProps: "transform,opacity",
                },
            );
        ScrollTrigger.refresh();
    });
});

// WAI-ARIA vertical tabs support arrows, Home, End, Enter, and pointer input.
const skillNodes = [...document.querySelectorAll(".skill-node")];
function selectAttribute(node, focus = false) {
    skillNodes.forEach((item) => {
        const selected = item === node;
        item.setAttribute("aria-selected", String(selected));
        item.tabIndex = selected ? 0 : -1;
        const panel = document.getElementById(
            item.getAttribute("aria-controls"),
        );
        if (panel) panel.hidden = !selected;
    });
    if (focus) node.focus();
    const panel = document.getElementById(node.getAttribute("aria-controls"));
    if (panel && !reducedMotion.matches) {
        gsap.killTweensOf(panel);
        gsap.fromTo(
            panel,
            { opacity: 0.2, x: 10 },
            {
                opacity: 1,
                x: 0,
                duration: 0.35,
                ease: "power2.out",
                clearProps: "transform,opacity",
            },
        );
        gsap.fromTo(
            node.querySelector(".node-icon"),
            { scale: 0.9 },
            {
                scale: 1,
                duration: 0.35,
                ease: "back.out(2)",
                clearProps: "transform",
            },
        );
    }
    ScrollTrigger.refresh();
}
skillNodes.forEach((node, index) => {
    node.addEventListener("click", () => selectAttribute(node));
    node.addEventListener("keydown", (event) => {
        let next;
        if (event.key === "ArrowDown") next = (index + 1) % skillNodes.length;
        if (event.key === "ArrowUp")
            next = (index - 1 + skillNodes.length) % skillNodes.length;
        if (event.key === "Home") next = 0;
        if (event.key === "End") next = skillNodes.length - 1;
        if (next !== undefined) {
            event.preventDefault();
            selectAttribute(skillNodes[next], true);
        }
    });
});

// Animation setup is reverted automatically when reduced motion changes.
media.add("(prefers-reduced-motion: no-preference)", () => {
    const heroElements = gsap.utils.toArray("[data-hero-reveal]");
    if (heroElements.length) {
        const intro = gsap.timeline();
        let playBook = true;
        try {
            playBook = !sessionStorage.getItem("zidane-grimoire-opened");
            sessionStorage.setItem("zidane-grimoire-opened", "true");
        } catch {
            /* Entry remains available in private storage contexts. */
        }
        if (playBook) {
            intro
                .set(".hero-book", { display: "block" })
                .fromTo(
                    ".hero-book",
                    { opacity: 0, y: 10, scale: 0.8 },
                    { opacity: 1, y: 0, scale: 1, duration: 0.45 },
                )
                .fromTo(
                    ".page-left",
                    { rotateY: 75 },
                    { rotateY: -22, duration: 0.85, ease: "power3.out" },
                    0.2,
                )
                .fromTo(
                    ".page-right",
                    { rotateY: -75 },
                    { rotateY: 22, duration: 0.85, ease: "power3.out" },
                    0.2,
                )
                .to(".hero-book", { opacity: 0, y: -20, duration: 0.4 }, 1.1)
                .set(".hero-book", { display: "none" });
        }
        intro.from(
            heroElements,
            {
                opacity: 0,
                y: 22,
                stagger: 0.12,
                duration: 0.8,
                ease: "power3.out",
                clearProps: "transform,opacity",
            },
            playBook ? 0.35 : 0,
        );
    }
    gsap.utils.toArray("[data-reveal]").forEach((element) => {
        const tween = gsap.fromTo(
            element,
            {
                autoAlpha: 0,
                y: 25,
                rotateY: -2,
                transformPerspective: 1000,
                transformOrigin: "left center",
            },
            {
                autoAlpha: 1,
                y: 0,
                rotateY: 0,
                transformPerspective: 1000,
                duration: 0.75,
                ease: "power3.out",
                clearProps: "transform,opacity,visibility,transformOrigin",
                scrollTrigger: {
                    trigger: element,
                    start: "top 94%",
                    once: true,
                },
            },
        );
        if (element.matches(".quest-card")) cardReveals.set(element, tween);
    });
    gsap.utils.toArray(".section-slash").forEach((slash) => {
        gsap.fromTo(
            slash,
            { scaleX: 0, opacity: 0 },
            {
                scaleX: 1,
                opacity: 0.7,
                duration: 0.8,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: slash.parentElement,
                    start: "top 85%",
                    once: true,
                },
            },
        );
    });
    const timeline = document.querySelector(".timeline-energy");
    if (timeline)
        gsap.from(timeline, {
            scaleY: 0,
            ease: "none",
            scrollTrigger: {
                trigger: ".mission-timeline",
                start: "top 75%",
                end: "bottom 65%",
                scrub: 0.4,
            },
        });
    const contactArt = document.querySelector(".contact-art");
    if (contactArt) {
        gsap.timeline({
            scrollTrigger: {
                trigger: contactArt,
                start: "top 88%",
                once: true,
            },
        })
            .from(".circle-outer", {
                opacity: 0,
                scale: 0.7,
                rotation: -35,
                duration: 1.3,
                ease: "power3.out",
            })
            .from(
                ".circle-diamond",
                { opacity: 0, scale: 0.6, rotation: 0, duration: 1.1 },
                0.2,
            )
            .from(
                ".circle-inner",
                { opacity: 0, scale: 0.7, duration: 0.9 },
                0.4,
            )
            .from(
                ".contact-clover, .circle-star",
                { opacity: 0, scale: 0.85, duration: 0.6, stagger: 0.1 },
                0.7,
            );
    }
});

if (document.fonts) document.fonts.ready.then(() => ScrollTrigger.refresh());
window.addEventListener(
    "load",
    () => {
        ScrollTrigger.refresh();
        if (initialHash && window.location.hash === initialHash) {
            document.getElementById(initialHash.slice(1))?.scrollIntoView({
                behavior: "instant",
                block: "start",
            });
            ScrollTrigger.update();
        }
    },
    { once: true },
);
window.addEventListener("pagehide", (event) => {
    if (!event.persisted) {
        media.revert();
        cleanups.forEach((cleanup) => cleanup());
    }
});
