/* eslint-disable no-useless-escape */
export function escape(toOutput) {
  return toOutput.replace(/\&/g, '&amp;')
    .replace(/\</g, '&lt;')
    .replace(/\>/g, '&gt;')
    .replace(/\"/g, '&qout;')
    .replace(/\'/g, '&#x27')
    .replace(/\//g, '&#x2f')
}

export function appendCommentToDOM(container, comment, isPrepend) {
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

export function appendStyle(cssTemplate) {
  const styleElement = "<style type='text/css'></style>"
  $(document.head).prepend(styleElement)
  $('style').text(cssTemplate)
}
