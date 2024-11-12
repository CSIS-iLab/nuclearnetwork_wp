const Search = () => {
  const trigger = document.querySelector('#search-trigger')
  const searchEl = document.querySelector('#searchform')
  const close = document.querySelector('#search-close')
  const algolia = document.getElementsByClassName('aa-dropdown-menu')
  const searchInput = document.querySelector('#navSearchInput')

  trigger.addEventListener('click', function () {
    searchEl.classList.add('is-active')
    this.setAttribute('aria-expanded', 'true')
    this.classList.add('is-active')
    searchInput.focus()
  })

  close.addEventListener('click', function () {
    searchEl.classList.remove('is-active')
    trigger.setAttribute('aria-expanded', false)
    trigger.classList.remove('is-active')
    algolia[0].style.display = 'none'
  })
}

export default Search
