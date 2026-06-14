
(function () {

  const body = document.querySelector('body')

  const MobileMenuTriggers = document.querySelectorAll('.mobile-menu-trigger')
  const MobileHeader = document.getElementById('MobileHeader');

  MobileMenuTriggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
      tooglAllTriggerButtons()

      MobileHeader.classList.toggle('open')
      body.classList.toggle('lock')
    })
  })

  const tooglAllTriggerButtons = (trigges) => {
    MobileMenuTriggers.forEach(trigger => {
      trigger.classList.toggle('open')
    })
  }

  // document.addEventListener('DOMContentLoaded', () => {
  //     const trigger = document.querySelector('.mobile-menu-trigger');
  //     const parentItem = document.querySelector('.mobile-menu .menu-item-has-children');
  //     const submenu = parentItem?.querySelector('.mobile-menu  .sub-menu');
  //     console.log(parentItem)
  //     log(submenu)
  //
  //     if (trigger) trigger.click();
  //     if (parentItem && submenu) {
  //         console.log('GO')
  //         parentItem.classList.add('open');
  //         submenu.classList.add('active');
  //     }
  // });
})();

(function () {
  const items = document.querySelectorAll('.menu-item-has-children')
  items.forEach(item => {
    const link = item.querySelector('a')
    const submenu = item.querySelector('.sub-menu')

    item.addEventListener('click', e => {
      console.log(e.target)
      if (e.target.tagName === 'A') return;


      const isOpen = item.classList.contains('open')

      if (!isOpen) {
        item.classList.add('open')
        // submenu.classList.add('open')
        submenu.style.maxHeight = submenu.scrollHeight + 'px'
      } else {
        item.classList.remove('open')
        // submenu.classList.remove('open')
        submenu.style.maxHeight = null;
      }
    })
  })




})();


(function ($) {

  const SELECTOR = '.brz-slick-slider, .brz-carousel__slider';

  function patchSlider($slider) {
    if ($slider.data('patched')) return;

    $slider.data('patched', true);

    // базовые настройки
    $slider.slick('slickSetOption', 'speed', 440, true);
    $slider.slick('slickSetOption', 'cssEase', 'ease', true);
    // $slider.slick('slickSetOption', 'draggable', false, true);

    // контекстная настройка
    if ($slider.closest('.review-slider').length) {
      // $slider.slick('slickSetOption', 'draggable', false, true);
      $slider.slick('slickSetOption', 'slidesToScroll', 3, true);
      $slider.slick('slickSetOption', {
        slidesToScroll: 3,
        responsive: [
          {
            breakpoint: 992,
            settings: {
              arrows: false,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToScroll: 1
            }
          }
        ]
      }, true);
    }

    $slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      console.log(nextSlide);
    });
  }

  function scanAndPatch() {
    const sliders = $(SELECTOR);

    sliders.each(function () {
      const $slider = $(this);

      if ($slider.hasClass('slick-initialized')) {
        patchSlider($slider);
      }
    });
  }

  scanAndPatch();

  const observer = new MutationObserver(() => {
    scanAndPatch();
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });

})(jQuery);




const isTouch = 'ontouchstart' in window

document.querySelectorAll('.phone-button').forEach(container => {
  const link = container.querySelector('a[href^="tel:"]')
  if (!link) return

  container.addEventListener('click', async (e) => {
    if (isTouch) return // даем работать tel:

    e.preventDefault()

    let phone = link.getAttribute('href') || ''
    
    // очистка
    phone = phone
      .replace('tel:', '')
      .replace(/[()\-\s]/g, '')

    try {
      await navigator.clipboard.writeText(phone)
      showToast(container, 'Скопировано')
    } catch {
      fallbackCopy(phone)
      showToast(container, 'Скопировано')
    }
  })
})

function fallbackCopy(text) {
  const input = document.createElement('input')
  input.value = text
  document.body.appendChild(input)
  input.select()
  document.execCommand('copy')
  document.body.removeChild(input)
}
function showToast(container, text) {
  const link = container.querySelector('a[href^="tel:"]')
  if (!link) return

  let toast = container.querySelector('.phone-toast')

  if (!toast) {
    toast = document.createElement('div')
    toast.className = 'phone-toast'
    document.body.appendChild(toast) // важно: в body для точного позиционирования
  }

  toast.innerText = text

  const rect = link.getBoundingClientRect()

  // сначала делаем видимым, чтобы получить размеры
  toast.style.position = 'fixed'
  toast.style.opacity = '0'
  toast.style.display = 'block'

  const toastRect = toast.getBoundingClientRect()

  const left = rect.left + (rect.width / 2) - (toastRect.width / 2)
  const top = rect.bottom + 6

  toast.style.left = `${left}px`
  toast.style.top = `${top}px`
  toast.style.opacity = '1'

  clearTimeout(toast._timeout)

  toast._timeout = setTimeout(() => {
    toast.style.opacity = '0'
  }, 2000)
}