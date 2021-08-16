export function getComments(apiUrl, siteKey, cb) {
  $.ajax({
    url: `${apiUrl}/api_comments.php?site_key=${siteKey}`
  }).done((data) => {
    cb(data)
  })
}

export function addComments(apiUrl, siteKey, data, cb) {
  $.ajax({
    type: 'POST',
    url: `${apiUrl}/api_add_comment.php`,
    data
  }).done((data) => {
    cb(data)
  })
}
