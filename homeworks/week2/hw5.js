function join(arr, concatStr) {
  if (arr.length === 0) { // special case
    return ''
  }

  let result = arr[0]
  for (let i = 1; i < arr.length; i += 1) {
    result += concatStr + arr[i]
  }
  return result
}

function repeat(str, times) {
  let result2 = ''
  for (let j = 0; j < times; j++) {
    result2 += str
  }
  return result2
}

console.log(join(['a'], '!'))
console.log(repeat('a', 5))
