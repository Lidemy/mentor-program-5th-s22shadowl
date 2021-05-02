function solve(lines) {
  const M = lines[0]
  let winner = ''
  for (let i = 1; i <= M; i++) {
    const vs = lines[i].split(' ')
    const A = vs[0]
    const B = vs[1]
    const K = Number(vs[2])
    if (A === B) {
      winner = 'DRAW'
    } else if (compare(A, B, K)) {
      winner = 'A'
    }
    winner = 'B'

    console.log(winner)
  }
  function compare(a, b, k) {
    if (a.length !== b.length) {
      if (k === 1) {
        return (a.length > b.length)
      } else {
        return !((a.length > b.length))
      }
    } else { // 長度相等 比較位數
      a = a.split('')
      b = b.split('')
      for (let j = 0; j < a.length; j++) {
        if (a[j] !== b[j]) {
          if (k === 1) {
            return (a[j] > b[j])
          } else {
            return !(a[j] > b[j])
          }
        }
      }
    }
  }
}
solve()
