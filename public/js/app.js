let toggle = document.querySelector('.toggle');
let body = document.querySelector('body');

toggle.addEventListener('click', function() {
    body.classList.toggle('open');
})


const notifications = document.querySelectorAll('.notification-manager .notification');

setTimeout(() => {
    for(const notification of notifications){
        notification.style.opacity = 0;
        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}, 5000);

for(const notification of notifications){
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    });
}

const eye = document.querySelector(".feather-eye");
const eyeoff = document.querySelector(".feather-eye-off");
const passwordField = document.querySelector("input[type=password]");

eye.addEventListener("click", () => {
    eye.style.display = "none";
    eyeoff.style.display = "block";
    passwordField.type = "text";
});

eyeoff.addEventListener("click", () => {
    eyeoff.style.display = "none";
    eye.style.display = "block";
    passwordField.type = "password";
});