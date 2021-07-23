;(function ($) {
  // const numFiltersApplied = document.querySelectorAll('.fp-num_filters_applied')

  let hasRun = false


  // $(document).on('facetwp-refresh', function () {
  //   if (FWP.soft_refresh == true) {
  //     FWP.enable_scroll = true
  //   } else {
  //     FWP.enable_scroll = false
  //   }
  // })

  $(document).on('facetwp-loaded', function () {
    // if (FWP.enable_scroll == true) {
    //   const top = $('.archive__content').offset().top - 100
    //   $(window).scrollTop(top)
    // }

    modifyFSelectFacet()
    hasRun = true
  })


  function modifyFSelectFacet() {
    $('.facetwp-type-fselect').each(function () {
      const $facet = $(this)
      // console.log(FWP.settings)
      const facet_name = $facet.attr('data-name')
      const facet_label = FWP.settings.labels[facet_name]

      // Add Number of Selected Options to Wrapper
      const numSelected = FWP.facets[facet_name].length
      const noResults = document.querySelector('.no-results__heading')

      // Remove data attribute on no search results
      if (!noResults) {
        this.querySelector('.fs-label-wrap').setAttribute('data-num', numSelected)
      }

      // If these fields already exist, don't create them again.
      if (this.querySelector('.fs-label-field')) {
        return
      }

      // Add Facet Label
      const label = document.createElement('div')
      label.classList.add('fs-label-field')
      label.innerHTML = facet_label

      this.querySelector('.fs-label-wrap').prepend(label)
    })
  }


})(jQuery)