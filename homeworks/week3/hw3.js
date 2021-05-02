function solve(lines) {
  const times = lines[0]
  let num = 0
  let res = 0
  for (let i = 1; i <= times; i++) {
    num = Number(lines[i])
    res = 0
    for (let j = 2; j <= num; j++) {
      if (num % j === 0) {
        res += j
      }
    }
    if (res === num) {
      console.log('Prime')
    } else {
      console.log('Composite')
    }
  }
}
solve()
