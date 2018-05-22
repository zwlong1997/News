//判断是否包含在数组内
module.exports.inArray = function(arr,obj)
{
    let i = arr.length;
    while (i--) {
        if (arr[i] === obj) {
            return true;
        }
    }
    return false;
};

Array.prototype.baoremove = function(dx) 
{ 
  if(isNaN(dx)||dx>this.length){return false;} 
  this.splice(dx,1); 
} 