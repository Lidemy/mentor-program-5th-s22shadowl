function solve(lines) {
  const input = lines[0]
  let output = ''
  for (let i = input.length - 1; i >= 0; i--) {
    output += input[i]
  }

  if (input === output) {
    console.log('True')
  } else {
    console.log('False')
  }
}
solve()
