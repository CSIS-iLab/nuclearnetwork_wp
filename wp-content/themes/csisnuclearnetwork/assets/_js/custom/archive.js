document.addEventListener('facetwp-loaded', function () {
  modifyCheckboxes()
  modifyFSelect()
})

const modifyCheckboxes = () => {
  const checkbox = document.querySelectorAll('.facetwp-checkbox')
  for (let i = 0; i < checkbox.length; i++) {
    const span = document.createElement('span')
    span.classList.add('fs-checkbox')
    span.innerHTML = '<i></i>'

    checkbox[i].prepend(span)
  }
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
