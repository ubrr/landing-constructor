'use strict';

const e = React.createElement;

class TestButton extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }

  render() {
    if (this.state.liked) {
      return e(
          'button',
          { onClick: () => this.setState({ liked: false }) },
          'You liked this'
      );
    }

    return e(
        'button',
        { onClick: () => this.setState({ liked: true }) },
        'Like'
    );
  }
}

window.frames[0].document.querySelectorAll('.test_button_container').forEach(el => {
    ReactDOM.render(e(TestButton), el);
});
