function solve(lines) {
  const line = lines[0].split(' ')
  const min = Number(line[0])
  const max = Number(line[1])
  for (let i = min; i <= max; i++) {
    let check = i
    check += ''
    let result = 0
    for (let j = 0; j < check.length; j++) {
      result += Math.pow(check[j], check.length)
    }
    if (i === result) {
      console.log(i)
    }
  }
}
solve()
