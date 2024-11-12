import { Navigation } from './navbar'
import { setScrollbarSize } from './scrollbar'
import Search from './search'

document.addEventListener('DOMContentLoaded', function () {
  setScrollbarSize()
  Navigation()
  Search()
})
