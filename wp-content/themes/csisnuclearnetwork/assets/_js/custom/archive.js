document.addEventListener('facetwp-loaded', function () {
  modifyCheckboxes()
  modifyFSelect()
  modifyFSelectOptions()
  pageScroll()
})

const modifyCheckboxes = () => {
  const checkbox = document.querySelectorAll('.facetwp-checkbox')

  // Check to ensure elements are removed to prevent duplication
  resetElements()
  for (let i = 0; i < checkbox.length; i++) {
    const span = document.createElement('span')
    span.classList.add('fs-checkbox')
    span.innerHTML = '<i></i>'

    checkbox[i].prepend(span)
  }
}

const resetElements = () => {
  const box = document.querySelectorAll('.fs-checkbox')
  Array.from(box).forEach((el) => {
    return el.remove()
  })
}

const modifyFSelect = () => {
  const wrap = document.querySelectorAll('.fs-wrap')
  for (let i = 0; i < wrap.length; i++) {
    const placeholder = document.querySelectorAll('.fs-label')
    const text = Array.from(placeholder).map((t) => t.innerText)[i]
    if (['All Topics', 'All Series', 'All Authors'].includes(text)) {
      wrap[i].classList.add('fs-default')
    } else {
      wrap[i].classList.remove('fs-default')
    }
  }
}

const modifyFSelectOptions = () => {
  const counter = document.querySelectorAll('.fs-option-label')
  Array.from(counter).forEach((t) => {
    const splitText = t.innerText.split(' ')
    t.innerText = splitText.slice(0, splitText.length - 1).join(' ')
  })
}

const pageScroll = () => {
  window.scrollTo(0, 0)
}
