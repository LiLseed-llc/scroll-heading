(function() {
  document.addEventListener('DOMContentLoaded', function() {
    var box = document.querySelector('.scrollheading-target .scrollheading-box');
    var boxHeight = box.offsetHeight;
    var currentPosition = 0;
    var targetPosition = box.getBoundingClientRect().top + window.pageYOffset;

    function scrollheading() {
      var windowTop = window.pageYOffset;

      if (currentPosition !== windowTop) {
        if (windowTop > targetPosition) {
          box.classList.add('scrollheading-fixed', 'active');
        } else {
          box.classList.remove('scrollheading-fixed', 'active');
        }

        currentPosition = windowTop;
      }

      requestAnimationFrame(scrollheading);
    }

    var timeout;
    window.addEventListener('scroll', function() {
      requestAnimationFrame(scrollheading);
    });
  });
})();