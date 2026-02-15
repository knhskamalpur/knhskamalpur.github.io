document.addEventListener("DOMContentLoaded", function () {
    const targetElement = document.querySelector(".header-text h1");
    if (!targetElement) return;

    const textEn = "Kamalpur Netaji High School (H.S.)";
    const textBn = "কমলপুর নেতাজী উচ্চ বিদ্যালয় (উঃ মাঃ)";
    const texts = [textEn, textBn];
    let textIndex = 0;
    let charIndex = textEn.length;
    let isDeleting = true;

    function type() {
        const currentText = texts[textIndex];
        let typeSpeed = 100;

        if (isDeleting) {
            targetElement.textContent = currentText.substring(0, charIndex - 1);
            charIndex--;
            typeSpeed = 50;
        } else {
            targetElement.textContent = currentText.substring(0, charIndex + 1);
            charIndex++;
            typeSpeed = 100;
        }

        if (!isDeleting && charIndex === currentText.length) {
            isDeleting = true;
            typeSpeed = 5000;
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
            typeSpeed = 500;
        }

        setTimeout(type, typeSpeed);
    }

    setTimeout(type, 5000);
});
