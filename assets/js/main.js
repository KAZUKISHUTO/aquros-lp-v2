(() => {
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const fixedCta = document.querySelector("[data-fixed-cta]");
  const ctaAreas = document.querySelectorAll("[data-hide-fixed-cta]");

  // 同じLINEボタンが画面内に2つ並ばないよう、FVと問い合わせ欄が見えている間は固定CTAを隠す
  if (fixedCta && ctaAreas.length && "IntersectionObserver" in window) {
    const visibleAreas = new Set();
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          visibleAreas.add(entry.target);
        } else {
          visibleAreas.delete(entry.target);
        }
      });
      fixedCta.classList.toggle("fixed-cta--hidden", visibleAreas.size > 0);
    });
    ctaAreas.forEach((area) => observer.observe(area));
  }

  // ハンバーガーメニュー
  const drawer = document.querySelector("[data-drawer]");
  const menuButton = document.querySelector("[data-menu-open]");

  if (drawer && menuButton) {
    const panel = drawer.querySelector("[data-drawer-panel]");
    const closeButton = panel.querySelector("button[data-menu-close]");

    const setOpen = (open, restoreFocus = true) => {
      drawer.classList.toggle("drawer--open", open);
      menuButton.setAttribute("aria-expanded", String(open));
      document.body.style.overflow = open ? "hidden" : "";
      if (open) {
        closeButton.focus();
      } else if (restoreFocus) {
        menuButton.focus();
      }
    };

    menuButton.addEventListener("click", () => setOpen(true));
    drawer.querySelectorAll("[data-menu-close]").forEach((element) => {
      element.addEventListener("click", () => setOpen(false));
    });
    // ページ内リンクは閉じたあとそのまま移動させる
    drawer.querySelectorAll("[data-menu-link]").forEach((link) => {
      link.addEventListener("click", () => setOpen(false, false));
    });

    document.addEventListener("keydown", (event) => {
      if (!drawer.classList.contains("drawer--open")) {
        return;
      }
      if (event.key === "Escape") {
        setOpen(false);
        return;
      }
      // 開いている間はフォーカスをメニュー内にとどめる
      if (event.key === "Tab") {
        const focusables = panel.querySelectorAll("a[href], button");
        const first = focusables[0];
        const last = focusables[focusables.length - 1];
        if (event.shiftKey && document.activeElement === first) {
          event.preventDefault();
          last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
          event.preventDefault();
          first.focus();
        }
      }
    });
  }

  // 施工事例カルーセル（スワイプはブラウザ標準のスクロールに任せ、ボタンと自動切り替えを足す）
  document.querySelectorAll("[data-carousel]").forEach((carousel) => {
    const viewport = carousel.querySelector("[data-carousel-viewport]");
    const slides = Array.from(viewport.children);
    const controls = carousel.querySelector("[data-carousel-controls]");
    const dotsBox = carousel.querySelector("[data-carousel-dots]");
    const interval = 6000;
    let positions = [];
    let dots = [];
    let current = 0;
    let stopped = reduceMotion;
    let holding = false;
    let visible = false;

    const updateCurrent = () => {
      const left = viewport.scrollLeft;
      current = positions.reduce((nearest, position, index) => (
        Math.abs(position - left) < Math.abs(positions[nearest] - left) ? index : nearest
      ), 0);
      dots.forEach((dot, index) => dot.setAttribute("aria-current", String(index === current)));
    };

    const goTo = (index) => {
      const target = (index + positions.length) % positions.length;
      viewport.scrollTo({ left: positions[target], behavior: reduceMotion ? "auto" : "smooth" });
    };

    // 読んでいる途中で動かないよう、一度でも操作されたら自動切り替えを止める
    const stopAutoplay = () => {
      stopped = true;
    };

    // 画面幅によって一度に見える枚数が変わるため、止まれる位置とドットを作り直す
    const measure = () => {
      const max = viewport.scrollWidth - viewport.clientWidth;
      const start = slides[0].offsetLeft;
      positions = [];
      for (const slide of slides) {
        const position = Math.min(slide.offsetLeft - start, max);
        positions.push(position);
        if (position >= max) {
          break;
        }
      }

      dotsBox.textContent = "";
      dots = positions.map((_, index) => {
        const dot = document.createElement("button");
        dot.className = "carousel__dot";
        dot.type = "button";
        dot.setAttribute("aria-label", `${index + 1}件目の事例を表示`);
        dot.addEventListener("click", () => {
          stopAutoplay();
          goTo(index);
        });
        dotsBox.append(dot);
        return dot;
      });

      const scrollable = positions.length > 1;
      controls.hidden = !scrollable;
      carousel.classList.toggle("carousel--ready", scrollable);
      updateCurrent();
    };

    carousel.querySelector("[data-carousel-prev]").addEventListener("click", () => {
      stopAutoplay();
      goTo(current - 1);
    });
    carousel.querySelector("[data-carousel-next]").addEventListener("click", () => {
      stopAutoplay();
      goTo(current + 1);
    });

    let scrollFrame = 0;
    viewport.addEventListener("scroll", () => {
      cancelAnimationFrame(scrollFrame);
      scrollFrame = requestAnimationFrame(updateCurrent);
    }, { passive: true });
    viewport.addEventListener("pointerdown", stopAutoplay);
    viewport.addEventListener("wheel", stopAutoplay, { passive: true });

    // マウスを乗せている間・キーボードで操作している間は一時停止
    carousel.addEventListener("mouseenter", () => { holding = true; });
    carousel.addEventListener("mouseleave", () => { holding = false; });
    carousel.addEventListener("focusin", () => { holding = true; });
    carousel.addEventListener("focusout", () => { holding = false; });

    if ("IntersectionObserver" in window) {
      new IntersectionObserver(([entry]) => {
        visible = entry.isIntersecting;
      }, { threshold: 0.5 }).observe(carousel);
    }

    window.setInterval(() => {
      if (!stopped && !holding && visible && !document.hidden && positions.length > 1) {
        goTo(current + 1);
      }
    }, interval);

    let resizeTimer = 0;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(measure, 200);
    });
    measure();
  });

  // GSAPが読み込めない環境でも内容が見えるよう、初期状態の非表示はJS側でのみ設定する
  if (reduceMotion || !window.gsap || !window.ScrollTrigger) {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  // FVは読み込み時に、見出しから順にゆっくり表示する
  gsap.timeline({ defaults: { duration: 0.8, ease: "power2.out" } })
    .from(".fv__title-line", { y: 16, opacity: 0, stagger: 0.15 })
    .from(".fv__illust", { y: 16, opacity: 0 }, "-=0.4")
    .from(".fv__body", { y: 16, opacity: 0 }, "-=0.5");

  gsap.utils.toArray("[data-animate]").forEach((element) => {
    const isStagger = element.dataset.animate === "stagger";
    gsap.from(isStagger ? element.children : element, {
      y: 24,
      opacity: 0,
      duration: 0.6,
      ease: "power2.out",
      stagger: isStagger ? 0.12 : 0,
      scrollTrigger: {
        trigger: element,
        start: "top 85%",
        once: true,
      },
    });
  });

  // マーカーは画面に入ってから左から引く
  gsap.utils.toArray(".marker").forEach((marker) => {
    marker.classList.add("marker--hidden");
    ScrollTrigger.create({
      trigger: marker,
      start: "top 80%",
      once: true,
      onEnter: () => marker.classList.remove("marker--hidden"),
    });
  });

  // よくある質問は、答えの高さをなめらかに開閉する
  document.querySelectorAll(".faq__item").forEach((item) => {
    const question = item.querySelector(".faq__question");
    const answer = item.querySelector(".faq__answer");

    question.addEventListener("click", (event) => {
      event.preventDefault();
      if (gsap.isTweening(answer)) {
        return;
      }
      if (item.open) {
        gsap.to(answer, {
          height: 0,
          paddingBottom: 0,
          opacity: 0,
          overflow: "hidden",
          duration: 0.35,
          ease: "power1.out",
          onComplete: () => {
            item.open = false;
            gsap.set(answer, { clearProps: "all" });
          },
        });
      } else {
        item.open = true;
        gsap.from(answer, {
          height: 0,
          paddingBottom: 0,
          opacity: 0,
          overflow: "hidden",
          duration: 0.4,
          ease: "power1.out",
          clearProps: "all",
        });
      }
    });
  });
})();
