````php
@forelse($data as $key => $item)
     <tr>
        <td>{{$item->name}}</td>
     </tr>
 @empty
    <tr>
        <td style="text-align: center;color: red" colspan="9"> No Data Available</td>
   </tr>
@endforelse
````
> if array is empty then @empty part will be exec.