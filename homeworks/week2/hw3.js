function reverse(str) {
  const revStr = str.split('')
  let newStr = []
  for (let i = revStr.length; i >= 0; i--) {
    newStr.push(revStr[i])
  }
  newStr = newStr.join('')
  console.log(newStr)
}

reverse('hello')
