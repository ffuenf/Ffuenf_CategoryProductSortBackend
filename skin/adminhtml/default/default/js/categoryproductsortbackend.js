var isBackend = typeof FORM_KEY != 'undefined';

function changeOrder(categoryId, productId, neighbourId, ajaxBlockUrl, listId, listTag)
{
  if (!isBackend) {
    // display centered loader hint box with icon and text
    var scrollTop = $(document).viewport.getScrollOffsets().top;
    var avTop     = ($(document).viewport.getHeight() / 2) - ($('categoryproductsortbackend-preloader').getLayout().get('margin-box-height') / 2) + scrollTop;
    if (avTop <= 10) {
      avTop = 10;
    }
    var styles = { top : avTop + 'px' };
    $('categoryproductsortbackend-preloader').setStyle(styles);
    $('categoryproductsortbackend-preloader').removeClassName('hide');
  }

  new Ajax.Request(ajaxBlockUrl, {
    parameters: {
      categoryId: categoryId,
      productId: productId,
      neighbourId: neighbourId,
      isAjax: 'true',
      form_key: isBackend ? FORM_KEY : ''
    },
    onSuccess: function(transport) {
      if (isBackend) {
      try {
        if (transport.responseText.isJSON()) {
          var response = transport.responseText.evalJSON();
          if (response.error) {
            alert(response.message);
          }
          if(response.ajaxExpired && response.ajaxRedirect) {
            setLocation(response.ajaxRedirect);
          }
          resetListItems(listId, listTag, response);
        } else {
          alert(transport.responseText);
        }
      }
      catch (e) {
        alert(transport.responseText);
      }
      } else {
        $('categoryproductsortbackend-preloader').addClassName('hide');
      }
    }
  });
}

function processSorting (categoryId, listId, listTag, ajaxUrl)
{
  var listItemId;
  if (isBackend) {
  /**
  * Firefox bug/feature workaround for checkbox deselecting in the category products grid
  */
  $(listId).select(listTag).each(function(item) {
    clickEvents = item.getStorage().get('prototype_event_registry').get('click');
    clickEvents.each(function(wrapper){
      Event.observe(item.select('.checkbox').first(), 'click', wrapper.handler);
      });
    item.stopObserving('click');
  });
  }

  Sortable.create(listId, { tag: listTag,
    onUpdate: function(list) {
      var listSize = list.length;
      var counter = 0;
      list.select(listTag).each(function(item) {
        counter++;
        if(item.getAttribute('id') == listItemId) {

          if(counter == 1) {
            var delta = 0 - item.getAttribute('id').replace('item_','');
          } else {
            var previousItem = item.previous().getAttribute('id').replace('item_','');
            var delta = previousItem - item.getAttribute('id').replace('item_','');
          }

          var productId = getProductId(item, listTag);
          var neighbourId = getProductId(delta > 0 ? item.previous() : item.next(), listTag);

          changeOrder(categoryId, productId, neighbourId, ajaxUrl, listId, listTag);
          resetListItems(listId, listTag);
          throw $break;
        }
      });
    },
    onChange: function(item) {
      listItemId = item.getAttribute('id');
    }
  });

}

function resetListItems(listId, listTag, newOrder)
{
  var i = 0;
  var changePositions = false;
  var inputElement, newId;
  if (typeof newOrder == 'object') {
    newOrder = object2array(newOrder);
    changePositions = true;
  }
  $(listId).select(listTag).each(function(item) {
    i++;
    item.setAttribute('id', 'item_' + i);
    if (changePositions && (newId = newOrder[getProductId(item, listTag)])) {
      inputElement = item.select('input[type=text]').first();
      inputElement.setAttribute('value', newId);
      inputElement.triggerEvent('keyup');
    }
  });
}

function getProductId (item, listTag)
{
  if (listTag == 'tr') {
    var productId = item.down().next().innerHTML;
  } else {
    var productId = item.getAttribute('productId');
  }
  return parseInt(productId);
}

function object2array (obj)
{
  var arr = [];
  for (var key in obj) {
    if (obj.hasOwnProperty(key)) {
      arr[key] = obj[key];
    }
  }
  return arr;
}

function batchSort()
{
  var i = 0;
  catalog_category_productsJsObject.rows.each(function(row){
    i++;
    var position = $(row).getElementsByClassName('input-text')[0];
    position.value = i;
    position.triggerEvent('keyup');
  });
}

Element.prototype.triggerEvent = function(eventName)
{
  if (document.createEvent) {
    var evt = document.createEvent('HTMLEvents');
    evt.initEvent(eventName, true, true);
    this.dispatchEvent(evt);
  }
  if (this.fireEvent) {
    this.fireEvent('on' + eventName);
  }
};
