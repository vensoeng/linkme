function previewImage(event, boxImg = ".soeng_book") {
    var ShowImg = document.querySelectorAll(boxImg);

    var input = event.target;

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            ShowImg.forEach((element) => {
                element.querySelector('img').src = e.target.result;
                element.querySelector('img').setAttribute('srcset',e.target.result);
                element.classList.add('active-img');
                element.classList.add('txt-photo-box-active');
            });
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        ShowImg.forEach((element) => {
            element.querySelector('img').src = "#";
            element.classList.remove('active-img');
            element.classList.remove('txt-photo-box-active');
        });
    }
}

function activateWebForm(elementPost, elementGet = "#book-form") {
    var Epost = document.querySelector(elementPost);
    var webForms = document.querySelectorAll('.web-form');

    webForms.forEach((element) => {
        element.classList.remove('web-form-active');
    });

    if (Epost) {
        Epost.classList.add('web-form-active');
    } else {
        console.error(`Element not found: ${elementPost}`);
    }
}
function addActiveClassTolist(mainClass,listClass,activeClass = 'active')
{
    var main = document.querySelector(mainClass);
    var list = main.querySelectorAll(listClass);
    list.forEach((e,i) =>{
        e.addEventListener('click', function(){
            list.forEach((ee) =>{ee.classList.remove(activeClass)});
            e.classList.add(activeClass)
        })
    })
}

function laodAnimation(loader_text = 'Please wait',check = false){
    var main_loader = document.createElement("div");
    main_loader.classList.add('main-loader');
    var txt = `
    <div class="loader-container">
        <div class="loader">
            <div class="inner-circle"></div>
        </div>
        <p>${loader_text}</p>
    </div>
    `;
    main_loader.innerHTML = txt;
    document.body.prepend(main_loader);
    if(check == true){
        main_loader.remove();
    }
}

function alertForm(txt){
    var alertE = document.querySelector('.form-alert');
    if(alertE){
        var textE = alertE.querySelector('blockquote p');
        textE.innerHTML = txt;

        alertE.classList.add('form-alert-active');

        setTimeout(function() {
            alertE.classList.add('form-alert-active-off');
        }, 4500);

        setTimeout(function() {
            alertE.classList.remove('form-alert-active-off');
            alertE.classList.remove('form-alert-active');
        }, 4700)
    }
}

function handleScreenWidth(textLocation) {
    var screenWidth = screen.width;
    if (screenWidth < 950) {
        location.href = textLocation;
    }
}