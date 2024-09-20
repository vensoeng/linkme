// =============this is for edite profile data ============
function fetchPostData(element) {
    const action = element.getAttribute('action');
    const method = 'POST';
    
    const formData = new FormData(element);

    fetch(action, {
        method: method,
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() !== ''){
            alertForm(data);
        }else{
            console.log('data content is empty'+data);
        }
    })
    .catch(error => {
        if(error.trim !== ''){
            alertForm(data);
        }else{
            console.log('data content is empty');
        }
    });
}
// ============this is for edite profile user ================= 
var formEditProfilePicture = document.querySelectorAll('.form-pro');
document.addEventListener('DOMContentLoaded', function(){
    formEditProfilePicture.forEach((element) =>{
        element.addEventListener('submit', function(event){
            event.preventDefault();
            fetchPostData(element);
        });
    });
});
// ===============this is for edite user detail=============== 
var formEditeDetail = document.querySelector('#x-form-detail');
var btnFormEditeDetail = formEditeDetail.querySelector('#x-btn-edit-detail');
var txtActionFormEditeDetail = formEditeDetail.querySelector('input.txt-action');
var alertE = document.querySelector('.form-alert');
document.addEventListener('DOMContentLoaded', function(){
    //this is for check user name of user 
    var txtUsername = formEditeDetail.querySelector('.x-username input');
    txtUsername.addEventListener('change',function(event){
        if(event){
            formEditeDetail.addEventListener('submit', function(event){
                event.preventDefault();
                fetchPostData(formEditeDetail);
            });
            txtActionFormEditeDetail.setAttribute('value','checkusername');
            btnFormEditeDetail.click();
    
            txtActionFormEditeDetail.setAttribute('value','tb_user_detail');
        }else{
            txtActionFormEditeDetail.setAttribute('value','tb_user_detail');
        }
    });
    // this is for check email of user 
    var txtEmail = formEditeDetail.querySelector('.x-email input');
    txtEmail.addEventListener('change', function(event){
        if(event){
            formEditeDetail.addEventListener('submit', function(event){
                event.preventDefault();
                fetchPostData(formEditeDetail);
            });
            txtActionFormEditeDetail.setAttribute('value','checkemail');
            btnFormEditeDetail.click();
    
            txtActionFormEditeDetail.setAttribute('value','tb_user_detail');
        }else{
            txtActionFormEditeDetail.setAttribute('value','tb_user_detail');
        }
    });
    // this is for edit form detail 
    formEditeDetail.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(formEditeDetail.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alertForm(data);
            if(data.trim() == 'Your profile detail edit completed'){
                formEditeDetail.querySelector('.web-form').classList.remove('web-form-active');
                // setTimeout(function() {
                //     alertE.classList.remove('form-alert-active');
                // }, 2000);
            }
        })
        .catch(error => {
            alertForm(error);
            console.log(error);
        });
    });
})

// =================this is for edit user link========================= 
var formEditeLinks = document.querySelectorAll('[data-name="edite-link"]');
formEditeLinks.forEach((element) =>{
    element.addEventListener('submit', function(event){
        event.preventDefault();
        fetchPostData(element);
        element.querySelector('[data-name="btn-close-form-link"]').click();
    })
});
// =================this is for add new link ============================= 
var formAddNewLink = document.querySelector('.form-add-new-link');
document.addEventListener('DOMContentLoaded', function() {
    formAddNewLink.addEventListener('submit', function(event) {
        event.preventDefault();
        formAddNewLink.querySelector('.web-form-body > .head > .icon-ra').click();
        formAddNewLink.querySelector('.txt-photo-box').classList.remove('txt-photo-box-active');
        fetchPostData(formAddNewLink);
        formAddNewLink.reset();
    });
});
// ====================this is for delete link of user=============== 
var formDeleteLinks = document.querySelectorAll('[data-name="form-delete-link"]');
formDeleteLinks.forEach((element) => {
    element.addEventListener('submit', function(event) {
        event.preventDefault();
        var confirmed = confirm('Do you want to delete this item?');
        if (confirmed) {
            fetchPostData(element);
        }
    });
});
// ======================this is for edit status of link==================
var formEditStatusLinks = document.querySelectorAll('[data-name="form-edit-status-link"]');
formEditStatusLinks.forEach((element) =>{
    var txtChange = element.querySelector('.txt-change');
    var txtStatus = element.querySelector('.txt-status');
    txtChange.addEventListener('change', function(){
        element.querySelector('button').click();
        if(txtStatus.value == 1){
            txtStatus.value = 0;
        }else{
            txtStatus.value = 1;
        }
    });
    element.addEventListener('submit', function(event){
        event.preventDefault();
        fetchPostData(element);
    })
});
// ================this is for edite content============================= 
var formPostContent = document.querySelector('[data-name="form-post-content"]');

var btnEditContents = document.querySelectorAll('[data-name="btn-edit-content"]');
var postContentItems = document.querySelectorAll('.user-post ul .data_list');

btnEditContents.forEach((element,index) =>{
    element.addEventListener('click', function(){
        
        var mianGetValue = postContentItems[index].querySelector('[data-name="list-input-edite"]');
        var id = mianGetValue.querySelector('.txt-id').value;
        var status = mianGetValue.querySelector('.txt-status').value;
        var title =  mianGetValue.querySelector('.txt-title').value;
        var des = mianGetValue.querySelector('.txt-des').value;
        var img = mianGetValue.querySelector('.txt-img').value;

        formPostContent.querySelector('[data-name="post_title"]').value = title;
        formPostContent.querySelector('[data-name="post_des"]').value = des;
        
        var boxImg = formPostContent.querySelector('.x-box-post-content');
        img !== "" ? boxImg.classList.add('txt-photo-box-active') : boxImg.classList.remove('txt-photo-box-active');
        img !== "" ? boxImg.querySelector('img').setAttribute('src',window.location.origin+'/storage/upload/'+img) : boxImg.querySelector('img').setAttribute('src','');
        
        var selectStatusE = formPostContent.querySelector('[data-name="post_status"]');
        status == 1 ? selectStatusE.innerHTML = `<option value="1">Public</option><option value="2">Privete</option>`
        : selectStatusE.innerHTML = `<option value="2">Privete</option><option value="1">Public</option>`;

        var txtId = formPostContent.querySelector('.txt-id');
        txtId.setAttribute('value',id);

        formPostContent.querySelector('.txt-action').setAttribute('value','editContent');
        formPostContent.parentElement.classList.add('web-form-active');
    })
});
// ===============this is for close form post content================= 
var btnCloseFormPostContent = formPostContent.querySelector('.btn-close-form-post-content');
btnCloseFormPostContent.addEventListener('click', function(){
    formPostContent.parentElement.classList.remove('web-form-active');
    formPostContent.reset();
    formPostContent.querySelector('.x-box-post-content').classList.remove('txt-photo-box-active');
    formPostContent.querySelector('.txt-action').setAttribute('value','content');
});
var bgCloseFormPostContent = formPostContent.parentElement.querySelector('.form-b');
bgCloseFormPostContent.addEventListener('click', function(){
    formPostContent.parentElement.classList.remove('web-form-active');
    formPostContent.reset();
    formPostContent.querySelector('.x-box-post-content').classList.remove('txt-photo-box-active');
    formPostContent.querySelector('.txt-action').setAttribute('value','content');
});
// =============================this Is for delete content of user==================== 
var formDeleteContents = document.querySelectorAll('.form-delete-content');
formDeleteContents.forEach((element,index) => {
    element.addEventListener('submit', function (event) {
        event.preventDefault();
        var confirmed = confirm('Do you want to delete this item?');
        if (confirmed) {
            fetchPostData(element);
        }
        postContentItems[index].classList.add('data-list-remove');
    })
})
// ===================this is for post content========================= 
formPostContent.addEventListener('submit', function(event){
    event.preventDefault();
    fetchPostData(formPostContent);
    formPostContent.reset();
    formPostContent.parentElement.classList.remove('web-form-active');
});
// ========================this is for user follwer===================== 
var formFollows = document.querySelectorAll('.form-follow');
formFollows.forEach((element) =>{
    element.addEventListener('submit', function(event){
        event.preventDefault();
        element.parentElement.classList.toggle('list-active');

        var txtStatus = element.querySelector('.txt-status');
        txtStatus.value == 0 ? txtStatus.setAttribute('value',1) : txtStatus.setAttribute('value',0);

        fetchPostData(element);
    })
})
// ===============this is for see reaction=========================== 
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