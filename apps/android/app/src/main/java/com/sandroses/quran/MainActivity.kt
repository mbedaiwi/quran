package com.sandroses.quran

import android.annotation.SuppressLint
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.webkit.WebResourceRequest
import android.webkit.WebSettings
import android.webkit.WebView
import android.webkit.WebViewClient
import android.widget.Toast
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.Button
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.unit.dp
import androidx.compose.ui.viewinterop.AndroidView

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            MaterialTheme {
                QuranReaderScreen()
            }
        }
    }
}

private const val HOME_URL = "https://www.sandroses.com/quran"
private const val PREFS_NAME = "quran_reader"
private const val BOOKMARK_URL_KEY = "bookmark_url"

@SuppressLint("SetJavaScriptEnabled")
@Composable
fun QuranReaderScreen() {
    val context = LocalContext.current
    val webViewState = remember { mutableStateOf<WebView?>(null) }
    val currentUrlState = remember { mutableStateOf(HOME_URL) }

    Scaffold(
        topBar = {
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(horizontal = 12.dp, vertical = 10.dp),
                horizontalArrangement = Arrangement.spacedBy(8.dp)
            ) {
                Button(onClick = {
                    saveBookmark(context, currentUrlState.value)
                    Toast.makeText(context, "Bookmark saved", Toast.LENGTH_SHORT).show()
                }) {
                    Text("Save mark")
                }

                Button(onClick = {
                    val bookmark = loadBookmark(context)
                    if (bookmark == null) {
                        Toast.makeText(context, "No bookmark yet", Toast.LENGTH_SHORT).show()
                    } else {
                        webViewState.value?.loadUrl(bookmark)
                        Toast.makeText(context, "Opened bookmark", Toast.LENGTH_SHORT).show()
                    }
                }) {
                    Text("Go to mark")
                }
            }
        }
    ) { paddingValues ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(paddingValues)
        ) {
            AndroidView(
                modifier = Modifier.fillMaxSize(),
                factory = { viewContext ->
                    WebView(viewContext).apply {
                        settings.javaScriptEnabled = true
                        settings.domStorageEnabled = true
                        settings.allowFileAccess = false
                        settings.allowContentAccess = false
                        settings.mixedContentMode = WebSettings.MIXED_CONTENT_NEVER_ALLOW
                        settings.safeBrowsingEnabled = true

                        webViewClient = object : WebViewClient() {
                            override fun shouldOverrideUrlLoading(view: WebView?, request: WebResourceRequest?): Boolean {
                                val url = request?.url ?: return true
                                val allowedHost = url.host == "www.sandroses.com" || url.host == "sandroses.com"
                                val httpsOnly = url.scheme == "https"

                                return if (allowedHost && httpsOnly) {
                                    false
                                } else {
                                    viewContext.startActivity(Intent(Intent.ACTION_VIEW, Uri.parse(url.toString())))
                                    true
                                }
                            }

                            override fun onPageFinished(view: WebView?, url: String?) {
                                super.onPageFinished(view, url)
                                if (url != null) {
                                    currentUrlState.value = url
                                }
                            }
                        }

                        webViewState.value = this
                        val saved = loadBookmark(viewContext)
                        loadUrl(saved ?: HOME_URL)
                    }
                }
            )
        }
    }
}

private fun saveBookmark(context: Context, url: String) {
    val prefs = context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE)
    prefs.edit().putString(BOOKMARK_URL_KEY, url).apply()
}

private fun loadBookmark(context: Context): String? {
    val prefs = context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE)
    return prefs.getString(BOOKMARK_URL_KEY, null)
}
