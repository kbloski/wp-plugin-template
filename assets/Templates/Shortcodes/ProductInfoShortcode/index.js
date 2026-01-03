function wpspbnow_initProductGallerySwiper(swiper_class, thumbs) {
    const swiper = new Swiper('.swiper.'+swiper_class, {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next.'+swiper_class,
            prevEl: '.swiper-button-prev.'+swiper_class,
        },
        pagination: {
            el: '.swiper-pagination.'+swiper_class,
            clickable: true,
            renderBullet: function (index, className) {
                return `<button 
                        class="${className}" 
                        type="button" 
                        aria-label="Go to slide ${index + 1}"
                        style="background-image: url('${thumbs[index]}');"
                    ></button>`;
            },
        },
        mousewheel: {
            forceToAxis: true,   // 🔥 tylko w poziomie (nie blokuje pionowego scrolla strony)
            sensitivity: 1,      // prędkość przewijania
            releaseOnEdges: true // pozwala wyjść ze slidera na końcach
        },
        keyboard: {
            enabled: true,       // 🔥 pozwala też zmieniać slajdy strzałkami ← →
            onlyInViewport: true
        },
    });

}

