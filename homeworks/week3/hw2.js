function solve(lines) {
  const maxAndmin = lines[0].split(' ')
  const min = Number(maxAndmin[0])
  const max = Number(maxAndmin[1])
  for (let i = min; i <= max; i++) {
    let checkNum = i
    checkNum += ''
    let checkSum = 0
    for (let j = 0; j < checkNum.length; j++) {
      checkSum += Math.pow(checkNum[j], checkNum.length)
    }
    if (i === checkSum) {
      console.log(i)
    }
  }
}
solve()
