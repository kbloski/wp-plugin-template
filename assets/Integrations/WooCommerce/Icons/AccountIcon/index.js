// console.log('Account modal loaded');

// jQuery(function($){
//     const modal_class = 'ast-header-account-modal';
//     const el = $('.ast-header-account');

//     let astraMobileOverlay = null;
//     let modal = null;
//     let btnClose = null;

// const modalHeaderHtml = <?php echo json_encode( __("Konto", "astra") . Astra_Icons::get_icons('close') ); ?>;
//         const modalBodyHtml = <?= json_encode( ($user = wp_get_current_user())->ID === 0 ? __('Nie jesteś zalogowany.', 'astra') : sprintf(__('Jesteś zalogowany jako %s', 'astra'), $user->user_login) ) ?>;
//         const modalFooterHtml = <?= json_encode( is_user_logged_in() ? '<a href="/wp-json/wp_login_guard/v1/logout"><button>'.__('Wyloguj','astra').'</button></a>' : '<a href="/moje-konto"><button>'.__('Zaloguj','astra').'</button></a>') ?>;

//         if(el.length){
//             el.css('position','relative');

//             if(!el.find('.astra-mobile-cart-overlay').length){
//                 el.append('<div class="astra-mobile-cart-overlay"></div>');
//             }
//             astraMobileOverlay = el.find('.astra-mobile-cart-overlay');

//             if(!el.find('.'+modal_class).length){
//                 let newModal = $('<div>', {class: modal_class});
//                 newModal.append(
//                     $('<div>', {class: modal_class+'__header', html: modalHeaderHtml}),
//                     $('<div>', {class: modal_class+'__body', html: modalBodyHtml}),
//                     $('<div>', {class: modal_class+'__footer', html: modalFooterHtml})
//                 );
//                 el.append(newModal);
//             }

//             modal = el.find('.'+modal_class);
//             btnClose = el.find('.'+modal_class+' span.ast-icon.icon-close');

//             function toggleOverlay(isVisible){
//                 if(isVisible && $(window).width() < 921){
//                     astraMobileOverlay.css({'opacity':'1','visibility':'visible','cursor':'pointer','z-index':'998'});
//                 } else {
//                     astraMobileOverlay.css({'opacity':'','visibility':'','cursor':'','z-index':''});
//                 }
//             }

//             function setupEvents(){
//                 const isMobile = window.innerWidth < 921;
//                 el.off('mouseenter mouseleave click');
//                 modal.off('mouseleave');

//                 if(!isMobile){
//                     el.on('mouseenter',()=>{modal.addClass('is-open'); toggleOverlay(true);});
//                     el.on('mouseleave', e=>{
//                         setTimeout(()=>{
//                             if(!$(e.relatedTarget).closest('.'+modal_class).length && !$(e.relatedTarget).closest('.ast-header-account').length){
//                                 toggleOverlay(false);
//                                 modal.removeClass('is-open');
//                             }
//                         },100);
//                     });
//                     modal.on('mouseleave', e=>{
//                         if(!$(e.relatedTarget).closest('.ast-header-account').length){
//                             modal.removeClass('is-open');
//                             toggleOverlay(false);
//                         }
//                     });
//                 } else {
//                     el.on('click', ()=>{modal.toggleClass('is-open'); toggleOverlay(modal.hasClass('is-open'));});
//                 }
//             }

//             setupEvents();
//             window.addEventListener('resize', setupEvents);

//             btnClose.on('click', e=>{e.stopPropagation(); modal.removeClass('is-open'); toggleOverlay(false);});
//             astraMobileOverlay.on('click', ()=>{modal.removeClass('is-open'); toggleOverlay(false);});
//         }
//     });