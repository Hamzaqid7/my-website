const scrollBtn = document.getElementById("scroll2top");

  // Function to scroll to top when clicked by the user 
  // Show button when user scrolls down 1500px
  window.onscroll = function () {
  if (document.body.scrollTop > 1500 || document.documentElement.scrollTop > 1500) {
    scrollBtn.style.display = "flex";
  } else {
    scrollBtn.style.display = "none";
  }
};

// Scroll to top function
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: "smooth" });
}

// script.js
const searchInput = document.getElementById('productSearch');
const products = document.querySelectorAll('.product-card');

searchInput.addEventListener('input', () => {
  const searchTerm = searchInput.value.toLowerCase();

  products.forEach(product => {
    const productName = product.dataset.name.toLowerCase();
    
    if (productName.includes(searchTerm)) {
      product.style.display = 'grid';
    } else {
      product.style.display = 'none';
    }
  });
});

const trail = document.querySelector(".cursor-trail");

document.addEventListener("mousemove", (e) => {
  const x = e.clientX;
  const y = e.clientY;
  trail.style.transform = `translate(${x}px, ${y}px)`;
});
