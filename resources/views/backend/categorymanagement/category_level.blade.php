<div class="form-group">
    <label>Select Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
      <option value="0" @if(isset($categorydata['parent_id']) && $categorydata['parent_id'] == 0) selected="" @endif>Main Category</option>
      @if(!empty($getcategory))
      @foreach ($getcategory as $category1)
          <option value="{{$category1['id']}}" @if(isset($categorydata['parent_id']) && $categorydata['parent_id'] == $category1['id']) selected="" @endif>{{$category1['category_name']}}</option>
          @if(!empty($category1['subcategory']))
          @foreach ($category1['subcategory'] as $subcategory1)
              <option value="{{$subcategory1['id']}}"> &nbsp;&raquo;&nbsp;{{$subcategory1['category_name']}}</option>
          @endforeach
          @endif
      @endforeach
      @endif

      @if(!empty($category))
      @foreach ($category as $category1)
          <option value="{{$category1['id']}}" @if(isset($categorydata['parent_id']) && $categorydata['parent_id'] == $category1['id']) selected="" @endif>{{$category1['category_name']}}</option>
          @if(!empty($category1['subcategory']))
          @foreach ($category1['subcategory'] as $subcategory1)
              <option value="{{$subcategory1['id']}}"> &nbsp;&raquo;&nbsp;{{$subcategory1['category_name']}}</option>
          @endforeach
          @endif
      @endforeach
      @endif
    </select>
</div>
