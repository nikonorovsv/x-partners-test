const ajaxurl = location.origin + '/wp-admin/admin-ajax.php';

export class WPAjax {
  /**
   *
   * @param handlerClass
   * @param handlerMethod
   * @param nonce
   */
  constructor(handlerClass, handlerMethod, nonce) {
    this._request = {
      action: handlerClass,
      handler: handlerMethod,
      nonce,
    };
  }

  static serialize( data ) {
    let res = [];
    for (let name in data) {
      if (name === 'field') {
        data.field
          .forEach((val, idx) => {
            res.push(`field[${idx}]=${encodeURIComponent(val)}`);
          });

        continue;
      }
      res.push(`${name}=${encodeURIComponent(data[name])}`);
    }

    return res.join('&');
  }

  /**
   *
   * @param name
   * @param value
   */
  setValue(name, value) {
    this._request[name] = value;
  }

  /**
   *
   * @param payload
   */
  setValues(payload) {
    if (payload instanceof FormData) {
      for (const pair in payload.entries()) {
        this._request[pair[0]] = pair[1];
      }
      return;
    }
    this._request = { ...this._request, ...payload };
  }

  send() {
    const query = new URLSearchParams(this._request).toString();

    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', ajaxurl, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.responseType = 'json';
      xhr.onload = () => resolve(xhr.response);
      xhr.onerror = () => {
        resolve(undefined);
        console.error('** An error occurred during the XMLHttpRequest');
      };
      xhr.send(query);
    });
  }

  async load(props) {
    const { onSuccess, onError, payload } = props;
    try {
      if (payload !== undefined) {
        for (const key in payload) {
          this.setValue(key, payload[key]);
        }
      }
      const { success, data } = await this.send();
      if (success) {
        onSuccess(data);
      } else {
        onError !== undefined ? onError(data) : () => console.error(...data);
      }
    } catch (e) {
      console.error(e);
    }
  }
}

export default WPAjax;
