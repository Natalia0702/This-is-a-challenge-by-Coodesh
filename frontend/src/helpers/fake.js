export const randomNumber = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

export const range = (count = 5) => {
    return [...Array(count).keys()]
}

// for (a in [...Array(10).keys()]) {
//     console.log(a);
// }
