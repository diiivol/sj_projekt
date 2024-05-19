// Accordion
function toggleText(id) {
  var element = document.getElementById(id);
  if (element.style.display === 'none') {
    element.style.display = 'block';
    element.style.opacity = '0';
    var height = element.clientHeight + 'px';
    element.style.height = '0';
    setTimeout(function () {
      element.style.transition = 'height 0.3s ease, opacity 0.3s ease';
      element.style.height = height;
      element.style.opacity = '1';
    }, 0);
    setTimeout(function () {
      element.style.height = 'auto';
    }, 300);
  } else {
    element.style.height = element.clientHeight + 'px';
    element.style.opacity = '1';
    setTimeout(function () {
      element.style.transition = 'height 0.3s ease, opacity 0.3s ease';
      element.style.height = '0';
      element.style.opacity = '0';
    }, 0);
    setTimeout(function () {
      element.style.display = 'none';
      element.style.transition = '';
      element.style.height = 'auto';
    }, 300);
  }
}
//   