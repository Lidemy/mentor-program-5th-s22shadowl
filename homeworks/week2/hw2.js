function capitalize(str) {
  const strA = str.split('')
  strA[0] = strA[0].charCodeAt(0)
  if (strA[0] <= 122 && strA[0] >= 97) {
    strA[0] = String.fromCharCode(strA[0] - 32)
    str = strA.join('')
  }
  return str
}

console.log(capitalize('hello'))
