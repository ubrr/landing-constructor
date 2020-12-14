function testButtonComponent(editor)
{
  const comps = editor.DomComponents;
  comps.addType('test_button', {
    isComponent(el) {
      if ((el.getAttribute && el.getAttribute('class') === 'test_button_container ')
          || (el.attributes && el.attributes['class'] === 'test_button_container ')) {
            return {
              type: 'test_button'
            };
      }
    },

    model: {
      defaults: {
        tagName: 'div',
        droppable: true,
        editable: true,
        selectable: true,
        attributes: {
          class: 'test_button_container',
        },
      }
    },

    view: {
      init() {
        this.listenTo(this.model, 'change:sectionColorClass', this.handleChanges);
      },
      handleChanges() {
        ReactDOM.unmountComponentAtNode(this.el);
        this.render();
      },
      onRender() {
        const e = React.createElement;
        ReactDOM.render(e(TestButton), this.el);
      },
    }
  });

  editor.BlockManager.add('test_button_block', {
    label: 'Test button',
    category: 'Custom Section',
    attributes: {
      class:'fa fa-square'
    },
    content: {
      type: 'test_button',
    }
  });
}
