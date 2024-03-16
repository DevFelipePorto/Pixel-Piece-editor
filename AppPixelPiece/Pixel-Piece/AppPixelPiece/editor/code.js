var state;


function when_key_pressed_q7me66g62(event) {
  if (event.keyCode === 65) {
      if (state == 0) {
    state = 1;
  } else {
    state = 0;
  }
  while (state == 1) {
    setTimeout(function() {
      var element = document.getElementById("item");
      element.style.left = (parseInt(element.style.left) + 150) + "px";
      element.style.transition = "all 1s";
    }, 1 * 1000);
    setTimeout(function() {
      var element = document.getElementById("item");
      element.style.top = (parseInt(element.style.top) + 150) + "px";
      element.style.transition = "all 1s";
    }, 1 * 1000);
    setTimeout(function() {
      var element = document.getElementById("item");
      element.style.left = (parseInt(element.style.left) - 150) + "px";
      element.style.transition = "all 1s";
    }, 1 * 1000);
    setTimeout(function() {
      var element = document.getElementById("item");
      element.style.top = (parseInt(element.style.top) - 150) + "px";
      element.style.transition = "all 1s";
    }, 1 * 1000);
  }

  }
}

document.addEventListener("keydown", when_key_pressed_q7me66g62);
