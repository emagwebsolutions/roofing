
const ascendingSort = ( arr: string[] | number[] | {}[] )=>{
    return arr.sort((a: any,b: any)=>{
        if(a > b) return 1;
        if(b > a) return -1;
        return 0
    })
}

const descendingSort = ( arr: string[] | number[] | {}[] )=>{
    return arr.sort((a: any,b: any)=>{
        if(a < b) return 1;
        if(b < a) return -1;
        return 0
    })
}

export { ascendingSort,descendingSort }