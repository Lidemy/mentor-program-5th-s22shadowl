function join(arr, concatStr) {
    let result = '';
    for( let i = 0 ; i < arr.length ;i++ ){
        result += arr[i] + concatStr;
    }
    return result;
}

function repeat(str, times) {
    let result2 = '';
    for( let j = 0 ; j < times ; j++ ){
        result2 += str;
    }
  return result2;
}

console.log(join(['a'], '!'));
console.log(repeat('a', 5));


