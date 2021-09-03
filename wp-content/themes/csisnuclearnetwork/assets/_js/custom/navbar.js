/**
 * JS file for toggling classes on the navbar
 *
 */

const trigger = document.querySelector('.site-nav__trigger')
const navContainer = document.querySelector('.site-nav__container')
const nav = document.querySelector('.site-nav__menu')
// const parentMenus = document.querySelectorAll('.sub-menu')
// const parentEls = document.querySelectorAll('.menu-item-has-children')

const Navigation = () => {
  // menuFocus()
  toggleMenu()
  // toggleSubmenu()
  closeMenu()
  menuFunctions()
}

const ClickyMenus = function (menu) {
  // DOM element(s)
  const container = menu.parentElement
  let currentMenuItem

  this.init = function () {
    menuSetup()
    document.addEventListener('click', closeOpenMenu)
  }

  /*===================================================
  =            Menu Open / Close Functions            =
  ===================================================*/
  function toggleOnMenuClick(e) {
    const button = e.currentTarget

    // close open menu if there is one
    if (currentMenuItem && button !== currentMenuItem) {
      toggleSubmenu(currentMenuItem)
    }

    toggleSubmenu(button)
  }

  function toggleSubmenu(button) {
    const submenu = document.getElementById(button.getAttribute('aria-controls'))
    const mainMenuItem = button.parentElement

    if ('true' === button.getAttribute('aria-expanded')) {
      button.setAttribute('aria-expanded', false)
      submenu.setAttribute('aria-hidden', true)
      mainMenuItem.classList.remove('is-active')
      currentMenuItem = false
    } else {
      button.setAttribute('aria-expanded', true)
      submenu.setAttribute('aria-hidden', false)
      mainMenuItem.classList.add('is-active')
      preventOffScreenSubmenu(submenu)
      currentMenuItem = button
    }
  }

  function preventOffScreenSubmenu(submenu) {
    const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
      parent = submenu.offsetParent,
      menuLeftEdge = parent.getBoundingClientRect().left,
      menuRightEdge = menuLeftEdge + submenu.offsetWidth

    if (menuRightEdge + 32 > screenWidth) {
      // adding 32 so it's not too close
      submenu.classList.add('sub-menu--right')
    }
  }

  function closeOnEscKey(e) {
    if (27 === e.keyCode) {
      // we're in a submenu item
      if (null !== e.target.closest('ul[aria-hidden="false"]')) {
        currentMenuItem.focus()
        toggleSubmenu(currentMenuItem)

        // we're on a parent item
      } else if ('true' === e.target.getAttribute('aria-expanded')) {
        toggleSubmenu(currentMenuItem)
      }
    }
  }

  function closeOpenMenu(e) {
    if (currentMenuItem && !e.target.closest('#' + container.id)) {
      toggleSubmenu(currentMenuItem)
    }
  }

  /*===========================================================
  =            Modify Menu Markup & Bind Listeners            =
  =============================================================*/
  function menuSetup() {
    menu.classList.remove('no-js')

    menu.querySelectorAll('.sub-menu-container-depth-0').forEach((submenu) => {
      const menuItem = submenu.parentElement

      if ('undefined' !== typeof submenu) {
        const button = menuItem.getElementsByTagName('button')[0]

        setUpAria(submenu, button)

        // bind event listener to button
        button.addEventListener('click', toggleOnMenuClick)
        menu.addEventListener('keyup', closeOnEscKey)
      }
    })
  }

  function setUpAria(submenu, button) {
    const submenuId = submenu.getAttribute('id')
    let id
    if (null === submenuId) {
      id = button.textContent.trim().replace(/\s+/g, '-').toLowerCase() + '-submenu'
    } else {
      id = submenuId + '-submenu'
    }

    // set button ARIA
    button.setAttribute('aria-controls', id)
    button.setAttribute('aria-expanded', false)

    // set submenu ARIA
    submenu.setAttribute('id', id)
    submenu.setAttribute('aria-hidden', true)
  }
}

/* Create a ClickMenus object and initiate menu for any menu with .clicky-menu class */
const menus = document.querySelectorAll('.site-nav__menu')

function menuFunctions() {
  menus.forEach((menu) => {
    const clickyMenu = new ClickyMenus(menu)
    clickyMenu.init()
  })
}

// const menuFocus = () => {
//   parentMenus.forEach((parentMenu) => {
//     const topLevelLinks = parentMenu.querySelectorAll('a')
//     topLevelLinks.forEach((link) => {
//       link.addEventListener('focus', function () {
//         this.parentElement.parentElement.classList.add('focus')
//       })
//       const subMenuItem = link.parentElement

//       if (subMenuItem.nextElementSibling) {
//         const subMenu = subMenuItem.nextElementSibling
//         const subMenuLinks = subMenu.querySelectorAll('a')
//         const lastLinkIndex = subMenuLinks.length - 1
//         const lastLink = subMenuLinks[lastLinkIndex]

//         lastLink.addEventListener('blur', function () {
//           this.parentElement.parentElement.classList.remove('focus')
//         })
//       }
//     })
//   })
// }

// change the hamburger icon to close icon on mobile
const toggleMenu = () => {
  trigger.addEventListener('click', function () {
    if (navContainer.classList.contains('is-active')) {
      this.setAttribute('aria-expanded', 'false')
      this.classList.remove('is-active')
      navContainer.classList.remove('is-active')
    } else {
      navContainer.classList.add('is-active')
      this.setAttribute('aria-expanded', 'true')
      this.classList.add('is-active')
    }
  })
}

// const toggleSubmenu = () => {
//   parentEls.forEach((parentEl) => {
//     parentEl.addEventListener('click', function () {
//       if (parentEl.classList.contains('is-active')) {
//         this.setAttribute('aria-expanded', 'false')
//         this.classList.remove('is-active')
//       } else {
//         this.setAttribute('aria-expanded', 'true')
//         this.classList.add('is-active')
//       }
//     })
//   })
// }

const closeMenu = () => {
  document.addEventListener('click', function (e) {
    const buttonClicked = e.target === trigger || e.target.parentElement === trigger

    if (!nav.contains(e.target) && !buttonClicked) {
      trigger.setAttribute('aria-expanded', 'false')
      trigger.classList.remove('is-active')
      navContainer.classList.remove('is-active')
    }
  })
}

export { Navigation }
