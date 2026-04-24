import SwiftUI
import WebKit

struct ContentView: View {
    var body: some View {
        SafeQuranWebView(url: URL(string: "https://www.sandroses.com/quran")!)
            .ignoresSafeArea()
    }
}

struct SafeQuranWebView: UIViewRepresentable {
    let url: URL

    func makeUIView(context: Context) -> WKWebView {
        let config = WKWebViewConfiguration()
        config.defaultWebpagePreferences.allowsContentJavaScript = true
        config.limitsNavigationsToAppBoundDomains = true

        let webView = WKWebView(frame: .zero, configuration: config)
        webView.navigationDelegate = context.coordinator
        webView.isInspectable = false
        webView.load(URLRequest(url: url))
        return webView
    }

    func updateUIView(_ uiView: WKWebView, context: Context) {}

    func makeCoordinator() -> Coordinator {
        Coordinator()
    }

    final class Coordinator: NSObject, WKNavigationDelegate {
        private let allowedHosts: Set<String> = ["sandroses.com", "www.sandroses.com"]

        func webView(
            _ webView: WKWebView,
            decidePolicyFor navigationAction: WKNavigationAction,
            decisionHandler: @escaping (WKNavigationActionPolicy) -> Void
        ) {
            guard let targetURL = navigationAction.request.url,
                  let host = targetURL.host,
                  targetURL.scheme == "https",
                  allowedHosts.contains(host) else {
                if let externalURL = navigationAction.request.url {
                    UIApplication.shared.open(externalURL)
                }
                decisionHandler(.cancel)
                return
            }

            decisionHandler(.allow)
        }
    }
}
