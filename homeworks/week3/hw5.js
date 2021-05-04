function solve(lines) {
  const M = lines[0]
  for (let i = 1; i <= M; i++) {
    const vs = lines[i].split(' ')
    const A = vs[0]
    const B = vs[1]
    const K = Number(vs[2])
    let winner = ''
    if (A === B) {
      winner = 'DRAW'
    } else {
      winner = K * (compare(A, B)) > 0 ? 'A' : 'B'
    }
    console.log(winner)
  }
  function compare(a, b) {
    if (a.length !== b.length) {
      return a.length > b.length ? 1 : -1
    }
    return a > b ? 1 : -1
  }
}
solve()
