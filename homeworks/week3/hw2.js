function solve(lines) {
  const minandMax = lines[0].split(' ')
  const min = Number(minandMax[0])
  const max = Number(minandMax[1])
  for (let i = min; i <= max; i++) {
    const checkNum = String(i)
    let checkSum = 0
    for (let j = 0; j < checkNum.length; j++) {
      checkSum += Math.pow(checkNum[j], checkNum.length)
    }
    if (i === Number(checkSum)) {
      console.log(i)
    }
  }
}
solve(['5 200'])
