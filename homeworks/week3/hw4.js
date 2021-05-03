function solve(lines) {
  const originStr = lines[0]
  let reverseStr = ''
  for (let i = originStr.length - 1; i >= 0; i--) {
    reverseStr += originStr[i]
  }

  if (originStr === reverseStr) {
    console.log('True')
  } else {
    console.log('False')
  }
}
solve()
