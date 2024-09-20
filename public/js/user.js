// ======================this Is for see reaction ====================
var formSeeReactions = document.querySelectorAll('.form-seereacte');
var formPopup = document.querySelector('.form-reaction');
formSeeReactions.forEach((element) => {
  element.addEventListener('submit', function (event) {
    event.preventDefault();

    const action =  element.getAttribute("action");
    const method = "POST";
    const formData = new FormData(element);

    fetch(action, {
      method: method,
      body: formData,
      }).then((response) => response.text()).then((data) => {
        if (data.trim() !== "") {
          formPopup.querySelector('.reate').innerHTML = data;

          var uls = formPopup.querySelectorAll('.reate ul');
          var btnReactions = formPopup.querySelectorAll('.i-reaction');
          
          btnReactions.forEach((element, index) => {
            btnReactions[index].querySelector('span').innerText = uls[index].querySelectorAll('li').length;

            element.addEventListener('click', function () {
              uls.forEach((e) => { e.classList.remove('active') });
              btnReactions.forEach((e) => { e.classList.remove('i-reaction-active') });

              btnReactions[index].classList.add('i-reaction-active');
              uls[index].classList.add('active');
            });
          });

          formPopup.classList.add('form-reaction-active');
        }
      }).catch((error) => {
          if (error.trim !== "") {
            alertForm(data);
          } else {
            console.log("data content is empty");
          }
      });
  })

});