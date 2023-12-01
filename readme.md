# Gravity Forms Organic Vs Direct Traffic

User's want to track website traffic within form submission data itself. How user's are being acquired to the webiste. We do not have any direct addon to track this from gravity forms. In order to achieve this we have created this addon which tracks the user traffic on first visit and save them in cookie for further use.

## How it works :truck:
- Create the gravity form.
- Add hidden fields with lable `utm_source`, `utm_medium` and `utm_term` to track. We would be replacing the hidden fields value based on traffic data. So need same labels to target the form input.
- **Update** - We do not have settings to add the brandname. We have removed this settings and it would only populate as `direct`, instead of `brandname_direct`.
- On adding this settings and adding hidden fields to forms, on page load it would check for already defined utm_params (if present) or check the `document.referrer` function in js to identify this values and substitute the same with hidden fields.
- On form submit this value would also get submitted and helps user to find the lead from which user come to site and submitted the form.
- **Note** - Cookie would be stored for 30min. After cookie expiration if user visited the site again, it would check again how user was acquired to the site.

## Dependency :lock:
- Need `Gravity Forms` to able to work this plugin and this is registered as an addon.

## Author :construction_worker:

* **[rtCamp](https://rtcamp.com)**

## Contributors :bust_in_silhouette:

* **[Hit Bhalodia](https://github.com/hbhalodia)**

## License :page_with_curl:

This project is licensed under the GPL2 License - see the [LICENSE.md](LICENSE.md) file for details.

## Does this interest you? :sparkles:

<a href="https://rtcamp.com/"><img src="https://rtcamp.com/wp-content/uploads/sites/2/2019/04/github-banner@2x.png" alt="Join us at rtCamp, we specialize in providing high performance enterprise WordPress solutions"></a>
