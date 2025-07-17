"use client"

import type React from "react"

import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Checkbox } from "@/components/ui/checkbox"
import { Badge } from "@/components/ui/badge"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { Upload, FileText, Clock, DollarSign, CheckCircle } from "lucide-react"

export default function QuotePage() {
  const [step, setStep] = useState(1)
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    company: "",
    phone: "",
    projectType: "",
    material: "",
    quantity: "",
    timeline: "",
    budget: "",
    description: "",
    files: [],
    additionalServices: [],
  })

  const materials = [
    "PLA",
    "PLA+",
    "ABS",
    "PETG",
    "TPU",
    "ASA",
    "Standard Resin",
    "Tough Resin",
    "Flexible Resin",
    "Biocompatible Resin",
    "Nylon",
    "Carbon Fiber",
    "Metal (Steel)",
    "Metal (Aluminum)",
  ]

  const projectTypes = [
    "Rapid Prototyping",
    "Custom Parts",
    "Small Batch Production",
    "Architectural Models",
    "Medical Devices",
    "Automotive Parts",
    "Consumer Products",
    "Educational Models",
    "Art & Jewelry",
  ]

  const additionalServices = [
    { id: "design", label: "Design Consultation", price: "$50/hour" },
    { id: "finishing", label: "Post-Processing & Finishing", price: "$25/part" },
    { id: "assembly", label: "Assembly Services", price: "$30/hour" },
    { id: "rush", label: "Rush Delivery (24h)", price: "+50%" },
    { id: "quality", label: "Quality Inspection Report", price: "$75" },
  ]

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    if (step < 3) {
      setStep(step + 1)
    } else {
      // Handle form submission
      console.log("Form submitted:", formData)
      setStep(4) // Success step
    }
  }

  const renderStep = () => {
    switch (step) {
      case 1:
        return (
          <div className="space-y-6">
            <div className="text-center space-y-2">
              <h2 className="text-2xl font-bold">Contact Information</h2>
              <p className="text-muted-foreground">Let us know how to reach you</p>
            </div>
            <div className="grid md:grid-cols-2 gap-4">
              <div className="space-y-2">
                <Label htmlFor="name">Full Name *</Label>
                <Input
                  id="name"
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  required
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="email">Email Address *</Label>
                <Input
                  id="email"
                  type="email"
                  value={formData.email}
                  onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                  required
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="company">Company</Label>
                <Input
                  id="company"
                  value={formData.company}
                  onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="phone">Phone Number</Label>
                <Input
                  id="phone"
                  value={formData.phone}
                  onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                />
              </div>
            </div>
          </div>
        )

      case 2:
        return (
          <div className="space-y-6">
            <div className="text-center space-y-2">
              <h2 className="text-2xl font-bold">Project Details</h2>
              <p className="text-muted-foreground">Tell us about your 3D printing needs</p>
            </div>
            <div className="grid md:grid-cols-2 gap-4">
              <div className="space-y-2">
                <Label htmlFor="projectType">Project Type *</Label>
                <Select
                  value={formData.projectType}
                  onValueChange={(value) => setFormData({ ...formData, projectType: value })}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="Select project type" />
                  </SelectTrigger>
                  <SelectContent>
                    {projectTypes.map((type) => (
                      <SelectItem key={type} value={type}>
                        {type}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>
              <div className="space-y-2">
                <Label htmlFor="material">Preferred Material *</Label>
                <Select
                  value={formData.material}
                  onValueChange={(value) => setFormData({ ...formData, material: value })}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="Select material" />
                  </SelectTrigger>
                  <SelectContent>
                    {materials.map((material) => (
                      <SelectItem key={material} value={material}>
                        {material}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>
              <div className="space-y-2">
                <Label htmlFor="quantity">Quantity *</Label>
                <Input
                  id="quantity"
                  type="number"
                  placeholder="Number of parts"
                  value={formData.quantity}
                  onChange={(e) => setFormData({ ...formData, quantity: e.target.value })}
                  required
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="timeline">Timeline *</Label>
                <Select
                  value={formData.timeline}
                  onValueChange={(value) => setFormData({ ...formData, timeline: value })}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="When do you need this?" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="rush">Rush (24-48 hours)</SelectItem>
                    <SelectItem value="standard">Standard (3-5 days)</SelectItem>
                    <SelectItem value="flexible">Flexible (1-2 weeks)</SelectItem>
                    <SelectItem value="bulk">Bulk Order (2-4 weeks)</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>
            <div className="space-y-2">
              <Label htmlFor="description">Project Description *</Label>
              <Textarea
                id="description"
                placeholder="Describe your project, intended use, special requirements, etc."
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                rows={4}
                required
              />
            </div>
            <div className="space-y-2">
              <Label>Upload Files (STL, OBJ, CAD files)</Label>
              <div className="border-2 border-dashed border-border rounded-lg p-8 text-center">
                <Upload className="h-8 w-8 mx-auto mb-2 text-muted-foreground" />
                <p className="text-sm text-muted-foreground mb-2">Drag and drop your files here, or click to browse</p>
                <Button variant="outline" size="sm">
                  Choose Files
                </Button>
              </div>
            </div>
          </div>
        )

      case 3:
        return (
          <div className="space-y-6">
            <div className="text-center space-y-2">
              <h2 className="text-2xl font-bold">Additional Services & Budget</h2>
              <p className="text-muted-foreground">Customize your order with additional services</p>
            </div>
            <div className="space-y-4">
              <Label>Additional Services (Optional)</Label>
              {additionalServices.map((service) => (
                <div key={service.id} className="flex items-center space-x-2 p-3 border border-border rounded-lg">
                  <Checkbox
                    id={service.id}
                    checked={formData.additionalServices.includes(service.id)}
                    onCheckedChange={(checked) => {
                      if (checked) {
                        setFormData({
                          ...formData,
                          additionalServices: [...formData.additionalServices, service.id],
                        })
                      } else {
                        setFormData({
                          ...formData,
                          additionalServices: formData.additionalServices.filter((id) => id !== service.id),
                        })
                      }
                    }}
                  />
                  <div className="flex-1">
                    <Label htmlFor={service.id} className="font-medium">
                      {service.label}
                    </Label>
                  </div>
                  <Badge variant="secondary">{service.price}</Badge>
                </div>
              ))}
            </div>
            <div className="space-y-2">
              <Label htmlFor="budget">Budget Range (Optional)</Label>
              <Select value={formData.budget} onValueChange={(value) => setFormData({ ...formData, budget: value })}>
                <SelectTrigger>
                  <SelectValue placeholder="Select budget range" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="under-100">Under $100</SelectItem>
                  <SelectItem value="100-500">$100 - $500</SelectItem>
                  <SelectItem value="500-1000">$500 - $1,000</SelectItem>
                  <SelectItem value="1000-5000">$1,000 - $5,000</SelectItem>
                  <SelectItem value="over-5000">Over $5,000</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>
        )

      case 4:
        return (
          <div className="text-center space-y-6">
            <div className="mx-auto w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
              <CheckCircle className="h-8 w-8 text-primary" />
            </div>
            <div className="space-y-2">
              <h2 className="text-2xl font-bold">Quote Request Submitted!</h2>
              <p className="text-muted-foreground">
                Thank you for your interest in our 3D printing services. We'll review your requirements and get back to
                you within 24 hours with a detailed quote.
              </p>
            </div>
            <div className="bg-muted/50 rounded-lg p-6 space-y-4">
              <h3 className="font-semibold">What happens next?</h3>
              <div className="space-y-3 text-sm text-left">
                <div className="flex items-center space-x-3">
                  <div className="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-primary-foreground text-xs font-bold">
                    1
                  </div>
                  <span>We'll review your files and requirements</span>
                </div>
                <div className="flex items-center space-x-3">
                  <div className="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-primary-foreground text-xs font-bold">
                    2
                  </div>
                  <span>Our team will prepare a detailed quote</span>
                </div>
                <div className="flex items-center space-x-3">
                  <div className="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-primary-foreground text-xs font-bold">
                    3
                  </div>
                  <span>You'll receive the quote via email within 24 hours</span>
                </div>
              </div>
            </div>
            <Button asChild>
              <a href="/">Return to Home</a>
            </Button>
          </div>
        )

      default:
        return null
    }
  }

  return (
    <div className="min-h-screen bg-background text-foreground">
      <Navbar />

      <div className="container py-12">
        <div className="max-w-4xl mx-auto">
          {/* Header */}
          <div className="text-center space-y-4 mb-12">
            <Badge variant="secondary" className="w-fit mx-auto">
              Get Quote
            </Badge>
            <h1 className="text-4xl md:text-5xl font-bold">Request a Quote</h1>
            <p className="text-xl text-muted-foreground max-w-2xl mx-auto">
              Get a personalized quote for your 3D printing project. Fill out the form below and we'll get back to you
              within 24 hours.
            </p>
          </div>

          {/* Progress Indicator */}
          {step < 4 && (
            <div className="flex items-center justify-center space-x-4 mb-12">
              {[1, 2, 3].map((stepNumber) => (
                <div key={stepNumber} className="flex items-center">
                  <div
                    className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold ${
                      step >= stepNumber ? "bg-primary text-primary-foreground" : "bg-muted text-muted-foreground"
                    }`}
                  >
                    {stepNumber}
                  </div>
                  {stepNumber < 3 && <div className={`w-12 h-0.5 ${step > stepNumber ? "bg-primary" : "bg-muted"}`} />}
                </div>
              ))}
            </div>
          )}

          {/* Form */}
          <Card className="border-border/50">
            <CardContent className="p-8">
              <form onSubmit={handleSubmit}>
                {renderStep()}

                {step < 4 && (
                  <div className="flex justify-between mt-8">
                    <Button
                      type="button"
                      variant="outline"
                      onClick={() => setStep(Math.max(1, step - 1))}
                      disabled={step === 1}
                    >
                      Previous
                    </Button>
                    <Button type="submit">{step === 3 ? "Submit Quote Request" : "Next Step"}</Button>
                  </div>
                )}
              </form>
            </CardContent>
          </Card>

          {/* Info Cards */}
          {step < 4 && (
            <div className="grid md:grid-cols-3 gap-6 mt-12">
              <Card className="text-center border-border/50">
                <CardHeader>
                  <Clock className="h-8 w-8 mx-auto text-primary mb-2" />
                  <CardTitle className="text-lg">Fast Response</CardTitle>
                  <CardDescription>Get your quote within 24 hours</CardDescription>
                </CardHeader>
              </Card>
              <Card className="text-center border-border/50">
                <CardHeader>
                  <DollarSign className="h-8 w-8 mx-auto text-primary mb-2" />
                  <CardTitle className="text-lg">Competitive Pricing</CardTitle>
                  <CardDescription>Fair and transparent pricing</CardDescription>
                </CardHeader>
              </Card>
              <Card className="text-center border-border/50">
                <CardHeader>
                  <FileText className="h-8 w-8 mx-auto text-primary mb-2" />
                  <CardTitle className="text-lg">Detailed Quote</CardTitle>
                  <CardDescription>Complete breakdown of costs</CardDescription>
                </CardHeader>
              </Card>
            </div>
          )}
        </div>
      </div>

      <Footer />
    </div>
  )
}
