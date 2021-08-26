/**
 * JS file for toggling classes on the navbar
 *
 */

const trigger = document.querySelector('.site-nav__trigger')
const menu = document.querySelector('.site-nav__container')
const nav = document.querySelector('.site-nav__menu')
const parentMenus = document.querySelectorAll('.sub-menu')
const parentEls = document.querySelectorAll('.menu-item-has-children')

const Navigation = () => {
  menuFocus()
  toggleMenu()
  toggleSubmenu()
  closeMenu()
}

const menuFocus = () => {
  parentMenus.forEach((parentMenu) => {
    const topLevelLinks = parentMenu.querySelectorAll('a')
    topLevelLinks.forEach((link) => {
      link.addEventListener('focus', function () {
        this.parentElement.parentElement.classList.add('focus')
      })
      const subMenuItem = link.parentElement

      if (subMenuItem.nextElementSibling) {
        const subMenu = subMenuItem.nextElementSibling
        const subMenuLinks = subMenu.querySelectorAll('a')
        const lastLinkIndex = subMenuLinks.length - 1
        const lastLink = subMenuLinks[lastLinkIndex]

        lastLink.addEventListener('blur', function () {
          this.parentElement.parentElement.classList.remove('focus')
        })
      }
    })
  })
}

// change the hamburger icon to close icon on mobile
const toggleMenu = () => {
  trigger.addEventListener('click', function () {
    if (menu.classList.contains('is-active')) {
      this.setAttribute('aria-expanded', 'false')
      this.classList.remove('is-active')
      menu.classList.remove('is-active')
    } else {
      menu.classList.add('is-active')
      this.setAttribute('aria-expanded', 'true')
      this.classList.add('is-active')
    }
  })
}

const toggleSubmenu = () => {
  parentEls.forEach((parentEl) => {
    parentEl.addEventListener('click', function () {
      if (parentEl.classList.contains('is-active')) {
        this.setAttribute('aria-expanded', 'false')
        this.classList.remove('is-active')
      } else {
        this.setAttribute('aria-expanded', 'true')
        this.classList.add('is-active')
      }
    })
  })
}

const closeMenu = () => {
  document.addEventListener('click', function (e) {
    const buttonClicked = e.target === trigger || e.target.parentElement === trigger
    console.log(e)

    if (!nav.contains(e.target) && !buttonClicked) {
      trigger.setAttribute('aria-expanded', 'false')
      trigger.classList.remove('is-active')
      menu.classList.remove('is-active')
    }
  })
}

export { Navigation }
