function solve(lines) {
  const times = lines[0]
  let checkNum = 0
  let checkSum = 0
  for (let i = 1; i <= times; i++) {
    checkNum = Number(lines[i])
    checkSum = 0
    for (let j = 2; j <= checkNum; j++) {
      if (checkNum % j === 0) {
        checkSum += j
      }
    }
    if (checkSum === checkNum) {
      console.log('Prime')
    } else {
      console.log('Composite')
    }
  }
}
solve()
