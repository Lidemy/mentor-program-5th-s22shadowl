/* eslint-disable no-useless-escape */
function escape(toOutput) {
  return toOutput.replace(/\&/g, '&amp;')
    .replace(/\</g, '&lt;')
    .replace(/\>/g, '&gt;')
    .replace(/\"/g, '&qout;')
    .replace(/\'/g, '&#x27')
    .replace(/\//g, '&#x2f')
}

function appendCommentToDOM(container, comment, isPrepend) {
  const html = `<div class="card mt-2" >
                    <div class="card-body">
                    <h5 class="card-title">${escape(comment.nickname)}</h5>
                    <p class="card-text">${escape(comment.content)}</p>
                    </div>
                </div>
                `
  if (isPrepend) {
    container.prepend(html)
  } else {
    container.append(html)
  }
}

$(document).ready(() => {
  const commentDOM = $('.comments')
  let commentsCount = 0
  let commentsNow = 0
  $.ajax({
    url: 'http://mentor-program.co/mtr04group1/s22shadowl/week12/board/api_comments.php?site_key=s22shadowl'
  }).done((data) => {
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
  })

  $('.add-comment-form').submit((e) => {
    e.preventDefault()
    const newCommentData = {
      site_key: 's22shadowl',
      nickname: $('input[name=nickname]').val(),
      content: $('textarea[name=content]').val()
    }
    $.ajax({
      type: 'POST',
      url: 'http://mentor-program.co/mtr04group1/s22shadowl/week12/board/api_add_comment.php',
      data: newCommentData
    }).done((data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      $('input[name=nickname]').val('')
      $('textarea[name=content]').val('')
      appendCommentToDOM(commentDOM, newCommentData, true)
    })
  })
  $('.showmore-btn').click((e) => {
    $.ajax({
      url: 'http://mentor-program.co/mtr04group1/s22shadowl/week12/board/api_comments.php?site_key=s22shadowl'
    }).done((data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      const comments = data.discussions
      let commentsShow = commentsNow + 5
      if (commentsNow + 5 > commentsCount) {
        commentsShow = commentsCount
        $('.showmore-btn').hide()
      }
      for (let i = commentsNow; i < commentsShow; i++) {
        appendCommentToDOM(commentDOM, comments[i])
      }
      commentsNow += 5
    })
    console.log(commentsNow)
    console.log(commentsCount)
  })
})
