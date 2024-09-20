// =============this is for edite profile data ============
function fetchPostData(element) {
  const action = element.getAttribute("action");
  const method = "POST";

  const formData = new FormData(element);

  fetch(action, {
    method: method,
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      if (data.trim() !== "") {
        alertForm(data);
      } else {
        console.log("data content is empty" + data);
      }
    })
    .catch((error) => {
      if (error.trim !== "") {
        alertForm(data);
      } else {
        console.log("data content is empty");
      }
    });
}
// =================this Is for action follow to user======================= 
var formFollowers = document.querySelectorAll(".form-add-follow");
document.addEventListener("DOMContentLoaded", function () {
  formFollowers.forEach((element) => {
    element.addEventListener("submit", function (event) {
      event.preventDefault();
      fetchPostData(element);
      element.classList.toggle("active");
      var txtAction = element.querySelector(".txt-action");
      txtAction.value == "addfollower"
        ? txtAction.setAttribute("value", "deletefollower")
        : txtAction.setAttribute("value", "addfollower");
    });
  });
});
// ====================this is reacte post================================== 
var formReactes = document.querySelectorAll('.form-reacte');
formReactes.forEach((element) => {
  element.addEventListener('submit', function (event) {
    event.preventDefault();

    var parantE = element.parentElement;
    parantE.getAttribute('data-name') == 'addreacte' ? parantE.setAttribute('data-name', 'deletereact') : parantE.setAttribute('data-name', 'addreacte');

    var textElement = parantE.querySelector('.text');
    parantE.getAttribute('data-name') == 'addreacte' ? textElement.innerText = (parseInt(textElement.innerText) - 1) : textElement.innerText = (parseInt(textElement.innerText) + 1);

    element.querySelector('button').classList.toggle('active');

    fetchPostData(element);
    
    var txtAction = element.querySelector('.txt-action');
    txtAction.getAttribute('value') == 'addreacte' ? txtAction.setAttribute('value', 'deletereacte') : txtAction.setAttribute('value', 'addreacte');
  });
})
// ================this is for user nitification==================== 
var formNotification = document.querySelector('.form-notification');
var btnNotification = document.querySelector('#btn-notification');
formNotification.addEventListener('submit', function (event) {
  event.preventDefault();
  btnNotification.classList.add('active');
  fetchPostData(formNotification);
});
// ===================this is for all post content of user ================== 
var btnCloseFormPost = document.querySelector('.btn-close-form-post-content');
var formContent = document.querySelector('#form-post form');
btnCloseFormPost.addEventListener('click', function () {
  var conf = confirm('Do you want to dicart this post?');
  if (conf) {
    formContent.reset();
    formContent.parentElement.classList.remove('web-form-active');
  }
});
formContent.parentElement.querySelector('.form-b').addEventListener('click', function () {
  var conf = confirm('Do you want to dicart this post?');
  if (conf) {
    formContent.reset();
    formContent.parentElement.classList.remove('web-form-active');
  }
});
formContent.addEventListener('submit', function (event) {
  event.preventDefault();
  fetchPostData(formContent);
  formContent.reset();
  formContent.parentElement.classList.remove('web-form-active');
})
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

