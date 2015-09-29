function changeOrder(categoryId, productId, neighbourId, ajaxBlockUrl, listId, listTag)
{
  new Ajax.Request(ajaxBlockUrl, {
    parameters: {
      categoryId: categoryId,
      productId: productId,
      neighbourId: neighbourId,
      isAjax: 'true',
      form_key: FORM_KEY
    },
    onSuccess: function(transport) {
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
    }
  });
}

function processSorting (categoryId, listId, listTag, ajaxUrl)
{
  var listItemId;
  /**
  * Firefox bug/feature workaround for checkbox deselecting in the category products grid
  */
  $(listId).select(listTag).each(function(item) {
    clickEvents = item.getStorage().get('prototype_event_registry').get('click');
    clickEvents.each(function(wrapper){
      //console.log(wrapper.handler);
      Event.observe(item.select('.checkbox').first(), 'click', wrapper.handler);
    });
    item.stopObserving('click');
  });

  Sortable.create(listId, { tag: listTag,
    onUpdate: function(list) {
      var counter = 0;
      var delta,
          previousItem,
          productId,
          neighbourId;
      list.select(listTag).each(function(item) {
        counter++;
        if(item.getAttribute('id') === listItemId) {
          if(counter === 1) {
            delta = 0 - item.getAttribute('id').replace('item_','');
          } else {
            previousItem = item.previous().getAttribute('id').replace('item_','');
            delta = previousItem - item.getAttribute('id').replace('item_','');
          }
          productId = getProductId(item, listTag);
          neighbourId = getProductId(delta > 0 ? item.previous() : item.next(), listTag);
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
  if (typeof newOrder === 'object') {
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
  var productId;
  if (listTag === 'tr') {
    productId = item.down().next().innerHTML;
  } else {
    productId = item.getAttribute('productId');
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

function resetListItemsFrontend(listId, listTag, dndproducts)
{
  var i = 0;
  var productIds = dndproducts.evalJSON();
  $(listId).select(listTag+'.item').each(function(item) {
    i++;
    item.setAttribute('id', 'item_' + i);
    item.setAttribute('productId', productIds[i - 1]);
    item.addClassName('dnd-item');
  });
}

Element.prototype.triggerEvent = function(eventName)
{
  var evt;
  if (document.createEvent) {
    evt = document.createEvent('HTMLEvents');
    evt.initEvent(eventName, true, true);
    this.dispatchEvent(evt);
  }
  if (this.fireEvent) {
    this.fireEvent('on' + eventName);
  }
};
