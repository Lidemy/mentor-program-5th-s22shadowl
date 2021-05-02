const readline = require('readline')

const lines = []
const rl = readline.createInterface({
  input: process.stdin
})

rl.on('line', (line) => {
  lines.push(line)
})

rl.on('close', (line) => {
  lines.push(line)
})

function solve(lines) {
  const times = lines[0]
  let print = ''
  for (let i = 1; i <= times; i++) {
    print += '*'
    console.log(print)
  }
}
solve()
