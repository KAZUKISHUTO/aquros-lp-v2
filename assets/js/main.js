(() => {
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

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // GSAPが読み込めない環境でも内容が見えるよう、初期状態の非表示はJS側でのみ設定する
  if (reduceMotion || !window.gsap || !window.ScrollTrigger) {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  gsap.utils.toArray("[data-animate]").forEach((element) => {
    gsap.from(element, {
      y: 24,
      opacity: 0,
      duration: 0.6,
      ease: "power2.out",
      scrollTrigger: {
        trigger: element,
        start: "top 85%",
        once: true,
      },
    });
  });
})();
