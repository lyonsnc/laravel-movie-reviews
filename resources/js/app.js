//
document.addEventListener('DOMContentLoaded', () => {
    const flashMessage = document.querySelector('.flash-message');

    if (!flashMessage){
        return;
    }

    requestAnimationFrame(() => {
        flashMessage.classList.add('show');
    });
    setTimeout(() => {
        flashMessage.classList.remove('show');

        setTimeout(() => {
            flashMessage.remove();
        }, 300);
    }, 3000);
});