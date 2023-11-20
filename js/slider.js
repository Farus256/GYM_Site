window.addEventListener("DOMContentLoaded", () => {
  let currentSlide = 0;
  const slides = document.querySelectorAll(".slide");
  const dots = document.querySelectorAll(".dot");
  const nextBtn = document.querySelector(".next-btn");
  const prevBtn = document.querySelector(".prev-btn");

  function showSlide(slideIndex) {
    slides.forEach((slide, index) => {
      if (index === slideIndex) {
        slide.style.display = "block";
        dots[index].classList.add("active");
      } else {
        slide.style.display = "none";
        dots[index].classList.remove("active");
      }
    });
    currentSlide = slideIndex;
  }

  function changeSlide(step) {
    showSlide((currentSlide + step + slides.length) % slides.length);
  }

  nextBtn.addEventListener("click", () => {
    changeSlide(1);
  });

  prevBtn.addEventListener("click", () => {
    changeSlide(-1);
  });

  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      showSlide(index);
    });
  });
  console.log(dots);
  showSlide(currentSlide);
});
