document.addEventListener("DOMContentLoaded", () => {
  // ハンバーガーメニュー
  const hamburger = document.querySelector(".bl_headerHum");
  const nav = document.getElementById("js-nav");
  const { body } = document;

  const toggleMenu = () => {
    nav.classList.toggle("is-open");
    body.classList.toggle("no-scroll");
    hamburger.classList.toggle("active");
  };

  const closeMenu = () => {
    nav.classList.remove("is-open");
    nav.classList.add("is-close");
    body.classList.remove("no-scroll");
    hamburger.classList.remove("active");
  };

  if (hamburger && nav) {
    hamburger.addEventListener("click", toggleMenu);
    document.querySelectorAll("#js-nav a").forEach((link) => {
      link.addEventListener("click", () => setTimeout(closeMenu, 100));
    });

    nav.addEventListener("click", (event) => {
      if (event.target === nav) closeMenu();
    });
  }

  // フェードイン処理（Intersection Observer）
  const fadeInElements = document.querySelectorAll(".fade-in");
  const fadeObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );
  fadeInElements.forEach((element) => fadeObserver.observe(element));

});

