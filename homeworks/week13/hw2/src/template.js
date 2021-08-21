export const cssTemplate = '.comments-area { margin-bottom: 10px;}'

export function getForm(className, commentsClassName) {
  return `<form class='${className}'>
    <div class="form-group">
        <label>暱稱</label>
        <input type="text" class="form-control" name="nickname" >
      </div>
    <div class="form-group">
        <label class="form-label">留言內容</label>
        <textarea class="form-control" rows="3" name="content"></textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">送出</button>
    </form>
    <div class='${commentsClassName}'>
    
    </div>
    `
}
export function getLoadMoreButton(className) {
  return `<div class='btn btn-primary ${className} showmore-btn mt-2'>載入更多</div>`
}
