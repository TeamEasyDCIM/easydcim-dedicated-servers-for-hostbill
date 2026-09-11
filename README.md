# EasyDCIM Dedicated Servers For HostBill

You can find the official module documentation under the following link: https://www.docs.easydcim.com/hostbill-integration/easydcim-dedicated-servers-for-hostbill/

In case you need any assistance from our side, please do not hesitate to contact our EasyDCIM support team by opening a ticket: https://www.easydcim.com/support/ticket

## Upgrading to 2.0.0

Version 2.0.0 moves the module from EasyDCIM **API v2 to API v3**.

The two APIs authenticate differently — v2 used a custom `apikey` header, v3
uses bearer tokens — so **existing server credentials will not work**. After
upgrading:

1. Issue an API v3 token in EasyDCIM for the account the module should act as.
2. In HostBill, open each EasyDCIM server and replace the password field with
   that token.
3. Use **Test Connection** to confirm it.

Nothing else needs migrating. Existing services keep their order and device IDs;
the EasyDCIM service ID that the new client-area pages need is resolved from the
order the first time it is required and stored from then on.

New options, all off by default, so existing products behave exactly as before
until you opt in:

- **SSH Keys**, **Sensors** — client area sections
- **Meter Power Usage** — collects average power draw for the `powerUsage`
  metered billing variable
- **Enable Stock Control** — keeps product stock in step with the devices
  EasyDCIM can actually provision
