import $ from 'jquery'
import { getComments, addComments } from './api'
import { appendCommentToDOM, appendStyle } from './utils'
import { cssTemplate, getLoadMoreButton, getForm } from './template'

export default function init(options) {
  let siteKey = ''
  let apiUrl = ''
  let containerElement = null
  let commentDOM = null
  let commentsCount = 0
  let commentsNow = 0
  let loadMoreClassName = ''
  let commentsClassName = ''
  let commentsSelector = ''
  let formClassName = ''
  let formSelector = ''
  siteKey = options.siteKey
  apiUrl = options.apiUrl
  containerElement = $(options.containerSelector)
  loadMoreClassName = `${siteKey}-load-more`
  commentsClassName = `${siteKey}-comments`
  commentsSelector = `.${commentsClassName}`
  formClassName = `${siteKey}-add-comment-form`
  formSelector = `.${formClassName}`
  const loadMoreButtonHTML = getLoadMoreButton(loadMoreClassName)

  appendStyle(cssTemplate)
  $(containerElement).append(getForm(formClassName, commentsClassName))
  $(containerElement).append(loadMoreButtonHTML)
  getNewComments()

  function getNewComments() {
    commentDOM = $(commentsSelector)
    getComments(apiUrl, siteKey, (data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      const comments = data.discussions
      commentsCount = comments.length
      commentsNow += 5
      for (let i = 0; i < 5; i++) {
        appendCommentToDOM(commentDOM, comments[i])
      }
      if (commentsNow > commentsCount) {
        $(`.${loadMoreClassName}`).hide()
      }
    })
  }
  $(document).on('click', `.${loadMoreClassName}`, (e) => {
    getNewComments()
  })

  $(formSelector).submit((e) => {
    e.preventDefault()
    const nicknameDOM = $(`${formSelector} input[name=nickname]`)
    const contentDOM = $(`${formSelector} textarea[name=content]`)
    const newCommentData = {
      site_key: siteKey,
      nickname: nicknameDOM.val(),
      content: contentDOM.val()
    }
    addComments(apiUrl, siteKey, newCommentData, (data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      nicknameDOM.val('')
      contentDOM.val('')
      appendCommentToDOM(commentDOM, newCommentData, true)
    })
  })
}
