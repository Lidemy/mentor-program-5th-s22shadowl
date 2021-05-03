function solve(lines) {
  const linesOfstars = lines[0]
  let output = ''
  for (let i = 1; i <= linesOfstars; i++) {
    output += '*'
    console.log(output)
  }
}
solve()
