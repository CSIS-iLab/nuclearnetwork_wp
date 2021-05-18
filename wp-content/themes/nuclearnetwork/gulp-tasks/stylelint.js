const argv = require('yargs').argv
const config = require('../gulp.config.js')
const { dest, src } = require('gulp')
const styleLint = require('gulp-stylelint')

// Flags whether we compress the output etc
const isProduction = process.env.NODE_ENV === 'production'

/*----------  StyleLint  -----------*/
function stylelint() {
  let autoFix = false
  let failAfterError = false
  if (argv.fix) {
    autoFix = true
  }

  if (argv.allow_stylelint_fail) {
    failAfterError = true
  }

  let stream = src(config.assets + config.sass.src + '/**/*.scss').pipe(
    styleLint({
      failAfterError: failAfterError,
      reporters: [{ formatter: 'string', console: true }],
      fix: autoFix,
    })
  )

  if (autoFix) {
    stream = stream.pipe(dest(config.assets + config.sass.src))
  }

  return stream
}

module.exports = stylelint
